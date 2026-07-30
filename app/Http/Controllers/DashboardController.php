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

class DashboardController extends Controller
{
    public function index(): View
    {
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

        // monthly sales/purchases for chart (last 6 months)
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

        $profit = $totalRevenue - $totalPurchaseCost;

        return view('dashboard', compact(
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
