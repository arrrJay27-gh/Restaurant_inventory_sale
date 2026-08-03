<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MenuItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use App\Models\WasteLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Gather all individual metrics from the database
        $totalItems = Item::count();
        $totalMenuItems = MenuItem::count();
        $totalSales = Sale::count();
        $totalSuppliers = Supplier::count();
        $totalWaste = WasteLog::count();
        $lowStock = Item::whereColumn('current_stock', '<', 'min_stock')->count();
        $totalRevenue = Sale::sum('total_amount');
        $totalPurchaseCost = PurchaseOrder::sum('total_amount');
        $totalUsers = User::count();
        $stockValue = Item::sum(DB::raw('current_stock * cost_per_unit'));
        $pendingPurchaseOrders = PurchaseOrder::where('status', '!=', 'received')->count();
        
        $incomingStock = PurchaseOrderItem::join('purchase_orders', 'po_items.po_id', '=', 'purchase_orders.id')
            ->where('purchase_orders.status', '!=', 'received')
            ->sum('quantity_ordered');

        $lowStockItems = Item::whereColumn('current_stock', '<', 'min_stock')
            ->orderBy('current_stock', 'asc')
            ->limit(5)
            ->get();

        // 2. Generate Chart Data (Last 6 Months)
        $chartLabels = [];
        $monthlySales = [];
        $monthlyPurchases = [];

        for ($i = 5; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = (clone $start)->endOfMonth();

            $chartLabels[] = $start->format('M');
            $monthlySales[] = (float) Sale::whereBetween('created_at', [$start, $end])->sum('total_amount');
            $monthlyPurchases[] = (float) PurchaseOrder::whereBetween('created_at', [$start, $end])->sum('total_amount');
        }

        // 3. Calculate financial breakdown
        $profit = $totalRevenue - $totalPurchaseCost;

        // 4. Implement Option 2: Map variables directly into the $metrics object for Blade
        $metrics = (object)[
            'total_revenue'      => $totalRevenue,
            'transactions_count' => $totalSales,
            'total_cost'         => $totalPurchaseCost, 
            'purchase_cost'      => $totalPurchaseCost,
            'orders_count'       => PurchaseOrder::count(), // Total orders count
            'pending_orders'     => $pendingPurchaseOrders,
            'incoming_qty'       => $incomingStock,
        ];

        // 5. Single return statement passing everything your view needs
        return view('dashboard', compact(
            'metrics',
            'totalItems',
            'totalMenuItems',
            'totalSales',
            'totalSuppliers',
            'totalWaste',
            'lowStock',
            'totalRevenue',
            'totalPurchaseCost',
            'totalUsers',
            'stockValue',
            'pendingPurchaseOrders',
            'incomingStock',
            'lowStockItems',
            'chartLabels',
            'monthlySales',
            'monthlyPurchases',
            'profit'
        ));
    }
}
