<?php 

namespace App\Http\Controllers; 

use App\Models\Item; 
use App\Models\StockLog; 
use Illuminate\Http\Request; 
use Illuminate\Contracts\View\View; 
use Illuminate\Http\RedirectResponse; 
use Illuminate\Support\Facades\Auth; 

class ItemController extends Controller 
{ 
    // 1. List all raw ingredients 
    public function index(): View 
    { 
        $items = Item::orderBy('name')->paginate(20); 
        return view('items.index', compact('items')); 
    } 

    // 2. Show form to create new ingredient 
    public function create(): View 
    { 
        return view('items.create'); 
    } 

    // 3. Store new ingredient into database 
    public function store(Request $request): RedirectResponse 
    { 
        $validated = $request->validate([ 
            'name' => 'required|string|max:255', 
            'sku' => 'required|string|max:100|unique:items,sku', 
            'category' => 'nullable|string|max:100', 
            'unit' => 'required|string|max:50', 
            'current_stock' => 'required|numeric|min:0', 
            'min_stock' => 'required|numeric|min:0', 
            'cost_per_unit' => 'required|numeric|min:0', 
        ]); 

        Item::create($validated); 

        return redirect()->route('items.index')->with('success', 'Inventory item added successfully.'); 
    } 

    // 4. Show stock adjustment entry page 
    public function adjustStock(Item $item): View 
    { 
        return view('items.adjust', compact('item')); 
    } 

    // FIXED: The duplicate "use App\Models\StockLog;" line has been removed from right here!
    public function stockLogs(): View 
    { 
        // Fetch all stock logs with their related items and the user who made the change 
        $logs = StockLog::with(['item', 'user']) 
            ->latest() 
            ->paginate(20); 

        return view('stocks.index', compact('logs')); 
    } 

    // 5. Process stock increment, reduction, or override logs 
    public function updateStock(Request $request, Item $item): RedirectResponse 
    { 
        $validated = $request->validate([ 
            'type' => 'required|in:IN,OUT,ADJUSTMENT', 
            'quantity' => 'required|numeric|min:0.01', 
            'reason' => 'nullable|string|max:255', 
        ]); 

        // Calculate and shift item quantities 
        if ($validated['type'] === 'IN') { 
            $item->increment('current_stock', $validated['quantity']); 
        } elseif ($validated['type'] === 'OUT') { 
            $item->decrement('current_stock', $validated['quantity']); 
        } else { 
            $item->current_stock = $validated['quantity']; 
            $item->save(); 
        } 

        // Build log trace model 
        StockLog::create([ 
            'item_id' => $item->id, 
            'type' => $validated['type'], 
            'quantity' => $validated['quantity'], 
            'reason' => $validated['reason'], 
            'user_id' => Auth::id(), 
        ]); 

        return redirect()->route('items.index')->with('success', 'Stock level updated successfully.'); 
    } 
}
