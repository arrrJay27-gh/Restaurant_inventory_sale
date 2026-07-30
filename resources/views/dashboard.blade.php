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
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Total Inventory Items</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalItems }}</p>
                    <p class="mt-2 text-sm text-slate-500">Active raw ingredients and stock items.</p>
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
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $totalItems ? number_format(($totalItems - $lowStock) / max($totalItems, 1) * 100, 0) : 0 }}%</p>
                            <p class="mt-2 text-sm text-slate-500">Items above minimum stock.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Supplier Network</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $totalSuppliers }}</p>
                            <p class="mt-2 text-sm text-slate-500">Active vendor partners.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Pending Reorders</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $lowStock }}</p>
                            <p class="mt-2 text-sm text-slate-500">Items needing immediate restock.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Average Waste Rate</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $totalSales ? number_format($totalWaste / max($totalSales, 1) * 100, 1) : 0 }}%</p>
                            <p class="mt-2 text-sm text-slate-500">Waste per sale transaction.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Quick Actions</h3>
                    <div class="mt-4 space-y-3">
                        <a href="#" class="block rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Create new sale</a>
                        <a href="#" class="block rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Add inventory item</a>
                        <a href="#" class="block rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Log waste / spoilage</a>
                        <a href="#" class="block rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-medium text-slate-700 hover:bg-slate-50">Create purchase order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
