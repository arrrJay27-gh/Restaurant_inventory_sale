<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MenuItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Sale;
use App\Models\Order;
use App\Models\User;
use App\Models\WasteLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Total Raw Ingredients (Item count)
        $totalItems = class_exists(Item::class) ? Item::count() : 0;
        
        // 2. Menu Items count
        $totalMenuItems = class_exists(MenuItem::class) ? MenuItem::count() : 0;

        // 3. Total Sales & Revenue
        $totalSales = 0;
        $totalRevenue = 0;
        $recentSales = collect();

        if (class_exists(Sale::class)) {
            $totalSales = Sale::count();
            $totalRevenue = Sale::sum('total_amount') ?? 0;
            $recentSales = Sale::latest()->limit(5)->get();
        } elseif (class_exists(Order::class)) {
            $totalSales = Order::count();
            $totalRevenue = Order::sum('total_amount') ?? 0;
            $recentSales = Order::latest()->limit(5)->get();
        }

        // 4. Waste Logs
        $totalWaste = class_exists(WasteLog::class) ? WasteLog::count() : 0;

        // 5. Low Stock Alert Logic (Na-restore at Inayos)
        $lowStock = 0;
        $lowStockItems = collect();

        if (class_exists(Item::class)) {
            try {
                // Sinusubukan kung 'current_stock' ang column name
                $lowStock = Item::whereColumn('current_stock', '<=', 'min_stock')->count();
                $lowStockItems = Item::whereColumn('current_stock', '<=', 'min_stock')
                    ->orderBy('current_stock', 'asc')
                    ->limit(5)
                    ->get();
            } catch (\Exception $e) {
                try {
                    // Fallback kung 'quantity' ang column name
                    $lowStock = Item::whereColumn('quantity', '<=', 'min_stock')->count();
                    $lowStockItems = Item::whereColumn('quantity', '<=', 'min_stock')
                        ->orderBy('quantity', 'asc')
                        ->limit(5)
                        ->get();
                } catch (\Exception $ex) {
                    $lowStock = 0;
                    $lowStockItems = collect();
                }
            }
        }

        // 6. Purchase Orders & Financial Stats
        $totalPurchaseCost = class_exists(PurchaseOrder::class) ? (PurchaseOrder::sum('total_amount') ?? 0) : 0;
        $totalUsers = class_exists(User::class) ? User::count() : 0;

        $stockValue = 0;
        if (class_exists(Item::class)) {
            try {
                $stockValue = Item::sum(DB::raw('current_stock * cost_per_unit')) ?? 0;
            } catch (\Exception $e) {
                try {
                    $stockValue = Item::sum(DB::raw('quantity * cost_per_unit')) ?? 0;
                } catch (\Exception $ex) {
                    $stockValue = 0;
                }
            }
        }

        $pendingPurchaseOrders = class_exists(PurchaseOrder::class) 
            ? PurchaseOrder::where('status', '!=', 'received')->count() 
            : 0;

        $incomingStock = 0;
        if (class_exists(PurchaseOrderItem::class) && class_exists(PurchaseOrder::class)) {
            try {
                $incomingStock = PurchaseOrderItem::join('purchase_orders', 'po_items.po_id', '=', 'purchase_orders.id')
                    ->where('purchase_orders.status', '!=', 'received')
                    ->sum('quantity_ordered') ?? 0;
            } catch (\Exception $e) {
                $incomingStock = 0;
            }
        }

        // 7. Monthly Sales & Purchases Chart Data (Last 6 months)
        $chartLabels = [];
        $monthlySales = [];
        $monthlyPurchases = [];

        for ($i = 5; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $chartLabels[] = $start->format('M');

            if (class_exists(Sale::class)) {
                $monthlySales[] = (float) Sale::whereBetween('created_at', [$start, $end])->sum('total_amount');
            } elseif (class_exists(Order::class)) {
                $monthlySales[] = (float) Order::whereBetween('created_at', [$start, $end])->sum('total_amount');
            } else {
                $monthlySales[] = 0;
            }

            if (class_exists(PurchaseOrder::class)) {
                $monthlyPurchases[] = (float) PurchaseOrder::whereBetween('created_at', [$start, $end])->sum('total_amount');
            } else {
                $monthlyPurchases[] = 0;
            }
        }

        $profit = $totalRevenue - $totalPurchaseCost;

        return view('dashboard', compact(
            'totalItems',
            'totalMenuItems',
            'totalSales',
            'totalWaste',
            'lowStock',
            'lowStockItems',
            'totalRevenue',
            'totalPurchaseCost',
            'totalUsers',
            'stockValue',
            'pendingPurchaseOrders',
            'incomingStock',
            'recentSales',
            'chartLabels',
            'monthlySales',
            'monthlyPurchases',
            'profit'
        ));
    }
}