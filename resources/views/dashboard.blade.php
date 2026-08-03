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
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-2">
                <!-- Sales Overview -->
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Sales Overview</p>
                            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ number_format($totalRevenue ?? 0, 2) }}</p>
                            <p class="mt-2 text-sm text-slate-500">Total revenue</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-500">Transactions</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $totalSales ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Purchase Overview -->
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Purchase Overview</p>
                            <p class="mt-4 text-3xl font-semibold text-slate-900">0.00</p>
                            <p class="mt-2 text-sm text-slate-500">Total purchase cost</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-500">Orders</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Counters Grid -->
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Total Ingredients</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalItems ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Active raw ingredients.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Menu Items</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalMenuItems ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Configured dishes and POS products.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Sales Transactions</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalSales ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Completed orders captured by POS.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Suppliers</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalSuppliers ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Vendor sources for purchase orders.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Waste Records</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalWaste ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Logged spoilage and kitchen losses.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Low Stock Alerts</p>
                    <p class="mt-4 text-4xl font-semibold text-rose-600">{{ $lowStock ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Items below reorder threshold.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>