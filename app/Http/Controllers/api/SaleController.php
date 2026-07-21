namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Item;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            // 1. Calculate Total
            $totalAmount = collect($validated['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });

            // 2. Create Sale Record
            $sale = Sale::create([
                'sale_number' => 'INV-' . strtoupper(Str::random(8)),
                'payment_method' => $validated['payment_method'],
                'total_amount' => $totalAmount,
            ]);

            // 3. Process Sale Items & Recipe Deductions
            foreach ($validated['items'] as $singleItem) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'menu_item_id' => $singleItem['menu_item_id'],
                    'quantity' => $singleItem['quantity'],
                    'unit_price' => $singleItem['unit_price'],
                ]);

                // Fetch recipe ingredients required for this menu item
                $recipes = Recipe::where('menu_item_id', $singleItem['menu_item_id'])->get();

                foreach ($recipes as $recipe) {
                    $deductQty = $recipe->quantity_required * $singleItem['quantity'];

                    // Decrement raw stock quantity in inventory
                    Item::where('id', $recipe->item_id)->decrement('current_stock', $deductQty);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Sale processed and inventory updated successfully.',
                'data' => $sale->load('items')
            ], 201);
        });
    }
}