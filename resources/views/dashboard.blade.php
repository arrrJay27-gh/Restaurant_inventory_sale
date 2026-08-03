@php
use App\Models\Item;
use App\Models\MenuItem;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\WasteLog;
use App\Models\PurchaseOrder;

// Base metrics
$totalItems = $totalItems ?? Item::count();
$totalMenuItems = $totalMenuItems ?? MenuItem::count();
$totalSales = $totalSales ?? Sale::count();
$totalSuppliers = $totalSuppliers ?? Supplier::count();
$totalWaste = $totalWaste ?? WasteLog::count();
$lowStock = $lowStock ?? Item::whereColumn('current_stock', '<', 'min_stock')->count();
$purchaseOrdersCount = PurchaseOrder::count();

// Safe Database Aggregations for Sales
try {
    $totalRevenue = Sale::sum('total_amount') ?? 0;
} catch (\Exception $e) {
    try {
        $totalRevenue = Sale::sum('amount') ?? 0;
    } catch (\Exception $ex) {
        $totalRevenue = 0; 
    }
}

// Safe Database Aggregations for Purchases
try {
    $totalPurchaseCost = PurchaseOrder::where('status', 'completed')->sum('total_price') ?? 0;
} catch (\Exception $e) {
    try {
        $totalPurchaseCost = PurchaseOrder::where('status', 'completed')->sum('grand_total') ?? 0;
    } catch (\Exception $ex) {
        $totalPurchaseCost = 0;
    }
}

try {
    $pendingPurchaseOrders = PurchaseOrder::where('status', 'pending')->count();
} catch (\Exception $e) {
    $pendingPurchaseOrders = 0;
}

$incomingStock = 0; 
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="mt-1 text-sm text-slate-500">Restaurant inventory, sales, and waste monitoring system.</p>
            </div>
            <div class="text-right bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                <p class="text-xs text-indigo-600 font-medium">Inventory Manager</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Top Overview Cards (Forced Side-by-Side using Flexbox) -->
            <div style="display: flex; gap: 24px; width: 100%;">
                
                <!-- Sales Overview Card -->
                <div class="relative overflow-hidden rounded-2xl p-6 shadow-xl transition-all duration-300 hover:scale-[1.01]" style="background-color: #0f172a; color: #ffffff; border: 1px solid #1e293b; flex: 1; min-width: 0;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold tracking-wide" style="color: #818cf8;">Sales Overview</h3>
                        <span class="rounded-lg px-3 py-1 text-xs font-semibold" style="background-color: rgba(99, 102, 241, 0.2); color: #c7d2fe; border: 1px solid rgba(99, 102, 241, 0.3);">Financials</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider" style="color: #94a3b8;">Total Revenue</p>
                            <p class="text-2xl font-extrabold mt-1" style="color: #ffffff;">₱{{ number_format($totalRevenue, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider" style="color: #94a3b8;">Transactions</p>
                            <p class="text-2xl font-extrabold mt-1" style="color: #ffffff;">{{ number_format($totalSales) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Purchase Overview Card -->
                <div class="relative overflow-hidden rounded-2xl p-6 shadow-xl transition-all duration-300 hover:scale-[1.01]" style="background-color: #0f172a; color: #ffffff; border: 1px solid #1e293b; flex: 1; min-width: 0;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold tracking-wide" style="color: #34d399;">Purchase Overview</h3>
                        <span class="rounded-lg px-3 py-1 text-xs font-semibold" style="background-color: rgba(16, 185, 129, 0.2); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3);">Procurement</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider" style="color: #94a3b8;">Total Cost</p>
                            <p class="text-lg font-extrabold mt-1" style="color: #ffffff;">₱{{ number_format($totalPurchaseCost, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider" style="color: #94a3b8;">Orders</p>
                            <p class="text-lg font-extrabold mt-1" style="color: #ffffff;">{{ number_format($purchaseOrdersCount) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider" style="color: #94a3b8;">Pending</p>
                            <p class="text-lg font-extrabold mt-1" style="color: #fbbf24;">{{ number_format($pendingPurchaseOrders) }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Counters Grid -->
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                
                <!-- Total Inventory Items -->
                <div class="group relative rounded-2xl bg-white border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Inventory Items</p>
                        <div class="rounded-xl bg-blue-50 p-2 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-extrabold text-slate-800">{{ number_format($totalItems) }}</p>
                </div>

                <!-- Menu Items -->
                <div class="group relative rounded-2xl bg-white border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Menu Items</p>
                        <div class="rounded-xl bg-amber-50 p-2 text-amber-600 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-extrabold text-slate-800">{{ number_format($totalMenuItems) }}</p>
                </div>

                <!-- Sales Transactions -->
                <div class="group relative rounded-2xl bg-white border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Sales Transactions</p>
                        <div class="rounded-xl bg-emerald-50 p-2 text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-extrabold text-slate-800">{{ number_format($totalSales) }}</p>
                </div>

                <!-- Suppliers -->
                <div class="group relative rounded-2xl bg-white border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Suppliers</p>
                        <div class="rounded-xl bg-purple-50 p-2 text-purple-600 transition-colors group-hover:bg-purple-600 group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-extrabold text-slate-800">{{ number_format($totalSuppliers) }}</p>
                </div>

                <!-- Waste Records -->
                <div class="group relative rounded-2xl bg-white border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Waste Records</p>
                        <div class="rounded-xl bg-orange-50 p-2 text-orange-600 transition-colors group-hover:bg-orange-600 group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-extrabold text-slate-800">{{ number_format($totalWaste) }}</p>
                </div>

                <!-- Low Stock Alerts -->
                <div class="group relative rounded-2xl bg-white border border-slate-100 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Low Stock Alerts</p>
                        <div class="rounded-xl bg-rose-50 p-2 text-rose-600 transition-colors group-hover:bg-rose-600 group-hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-extrabold {{ $lowStock > 0 ? 'text-rose-600 animate-pulse' : 'text-slate-800' }}">
                        {{ number_format($lowStock) }}
                    </p>
                </div>
            </div>

            <!-- Operational Summary Section -->
            <div class="rounded-2xl bg-white border border-slate-100 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-6 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Operational Summary</h3>
                        <p class="mt-1 text-sm text-slate-400">Review your core inventory efficiency in one place.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-600 border border-indigo-100">Live counts</span>
                </div>

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-2xl bg-slate-50 p-5 border border-slate-100/80 transition-all hover:bg-slate-100/50">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Stock Coverage Ratio</p>
                        <div class="mt-3 flex items-baseline justify-between">
                            <p class="text-2xl font-extrabold text-slate-800">
                                {{ $totalItems ? number_format(($totalItems - $lowStock) / max($totalItems, 1) * 100, 1) : 0 }}%
                            </p>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Optimal</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>