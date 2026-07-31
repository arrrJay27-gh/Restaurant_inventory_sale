@php
use App\Models\Ingredient;
use App\Models\MenuItem;
use App\Models\Order;

<<<<<<< HEAD
// Base metrics
$totalItems = $totalItems ?? Item::count();
$totalMenuItems = $totalMenuItems ?? MenuItem::count();
$totalSales = $totalSales ?? Sale::count();
$totalSuppliers = $totalSuppliers ?? Supplier::count();
$totalWaste = $totalWaste ?? WasteLog::count();
$lowStock = $lowStock ?? Item::whereColumn('current_stock', '<', 'min_stock')->count();
$purchaseOrdersCount = PurchaseOrder::count();

// Safe Database Aggregations
try {
    $totalRevenue = Sale::sum('total_amount') ?? 0;
} catch (\Exception $e) {
    // Fallback if 'total_amount' is named differently (e.g., 'grand_total', 'price', 'amount')
    try {
        $totalRevenue = Sale::sum('amount') ?? 0;
    } catch (\Exception $ex) {
        $totalRevenue = 0; 
    }
}

try {
    // Attempting query using fallback column guess if total_cost fails
    $totalPurchaseCost = PurchaseOrder::where('status', 'completed')->sum('total_price') ?? 0;
} catch (\Exception $e) {
    try {
        $totalPurchaseCost = PurchaseOrder::where('status', 'completed')->sum('grand_total') ?? 0;
    } catch (\Exception $ex) {
        $totalPurchaseCost = 0; // Absolute safety fallback to prevent crashing
    }
}

try {
    $pendingPurchaseOrders = PurchaseOrder::where('status', 'pending')->count();
} catch (\Exception $e) {
    $pendingPurchaseOrders = 0;
}

$incomingStock = 0; 
=======
$totalItems = class_exists(Ingredient::class) ? Ingredient::count() : 0;
$totalMenuItems = class_exists(MenuItem::class) ? MenuItem::count() : 0;
$totalSales = class_exists(Order::class) ? Order::count() : 0;
$totalSuppliers = 0;
$totalWaste = 0;
$lowStock = 0;
$purchaseOrdersCount = 0;
$totalRevenue = 0;
>>>>>>> c618e7e87d6aeca9df063f1b4b738dba7c0ef86b
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Restaurant inventory, sales, and waste overview.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-600">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">Inventory Manager</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
<<<<<<< HEAD
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-2">
                <!-- Sales Overview -->
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Sales Overview</p>
                            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ number_format($totalRevenue, 2) }}</p>
                            <p class="mt-2 text-sm text-slate-500">Total revenue</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-500">Transactions</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $totalSales }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Cost</p>
                            <p class="mt-2 text-xl font-semibold text-slate-900">{{ number_format($totalPurchaseCost, 2) }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Profit</p>
                            <p class="mt-2 text-xl font-semibold text-emerald-600">{{ number_format(($totalRevenue - $totalPurchaseCost), 2) }}</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <canvas id="salesChart" height="140"></canvas>
                    </div>
                </div>

                <!-- Purchase Overview -->
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Purchase Overview</p>
                            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ number_format($totalPurchaseCost, 2) }}</p>
                            <p class="mt-2 text-sm text-slate-500">Total purchase cost</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-500">Orders</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $purchaseOrdersCount }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Pending</p>
                            <p class="mt-2 text-xl font-semibold text-slate-900">{{ $pendingPurchaseOrders }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Incoming Qty</p>
                            <p class="mt-2 text-xl font-semibold text-slate-900">{{ number_format($incomingStock, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Counters Grid -->
=======
>>>>>>> c618e7e87d6aeca9df063f1b4b738dba7c0ef86b
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Total Ingredients</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalItems }}</p>
                    <p class="mt-2 text-sm text-slate-500">Active raw ingredients.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Menu Items</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalMenuItems }}</p>
                    <p class="mt-2 text-sm text-slate-500">Configured dishes and POS products.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Sales Transactions</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalSales }}</p>
                    <p class="mt-2 text-sm text-slate-500">Completed orders captured by POS.</p>
                </div>
<<<<<<< HEAD

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Suppliers</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalSuppliers }}</p>
                    <p class="mt-2 text-sm text-slate-500">Vendor sources for purchase orders.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Waste Records</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalWaste }}</p>
                    <p class="mt-2 text-sm text-slate-500">Logged spoilage and kitchen losses.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Low Stock Alerts</p>
                    <p class="mt-4 text-4xl font-semibold text-rose-600">{{ $lowStock }}</p>
                    <p class="mt-2 text-sm text-slate-500">Items below reorder threshold.</p>
                </div>
            </div>

            <!-- Operational Summary -->
            <div class="grid gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2 rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Operational Summary</h3>
                            <p class="mt-2 text-sm text-slate-500">Review your core operations in one place.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-violet-100 px-3 py-1 text-sm font-medium text-violet-700">Live counts</span>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Stock Coverage</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">
                                {{ $totalItems ? number_format(($totalItems - $lowStock) / max($totalItems, 1) * 100, 0) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
=======
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> c618e7e87d6aeca9df063f1b4b738dba7c0ef86b
