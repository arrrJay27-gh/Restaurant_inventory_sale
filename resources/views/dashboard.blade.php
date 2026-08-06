<x-app-layout>
    <!-- MAIN CONTAINER WITH LEFT MARGIN FOR SIDEBAR -->
    <div class="sm:ml-64 bg-[#F6FAF3] min-h-screen p-6 md:p-8">
        
        <!-- TOP HEADER BAR -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1A2E12] tracking-tight">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Restaurant inventory, sales, and waste overview.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-green-100/80 shadow-sm w-fit">
                <div class="w-10 h-10 bg-[#70C116] text-white font-black rounded-xl flex items-center justify-center text-sm shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-green-100 text-[#52930a] rounded-full">
                        {{ ucfirst(auth()->user()->role ?? 'Inventory Manager') }}
                    </span>
                </div>
            </div>
        </header>

        <!-- LOW STOCK ALERT BANNER -->
        @if(($lowStock ?? 0) > 0)
            <div class="mb-8 p-5 bg-red-50 border border-red-200 rounded-3xl shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-100 text-red-600 rounded-2xl shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-red-900">Low Stock Alert!</h4>
                        <p class="text-xs text-red-600 mt-0.5">There are <strong>{{ $lowStock }}</strong> item(s) running low on stock and need restocking.</p>
                    </div>
                </div>
                <a href="{{ route('items.index') }}" class="text-xs font-bold text-white bg-red-600 px-4 py-2.5 rounded-xl hover:bg-red-700 transition self-start sm:self-auto shrink-0 shadow-sm">
                    Check Inventory
                </a>
            </div>
        @endif

        <!-- TOP STATS CARDS (HIGHLIGHTED) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Sales Overview -->
            <a href="{{ route('sales.index') }}" class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm hover:shadow-md transition flex items-center justify-between group">
                <div class="space-y-1">
                    <p class="text-sm font-bold text-gray-500">Sales Overview</p>
                    <h2 class="text-3xl font-black text-gray-900">₱{{ number_format($totalRevenue ?? 0, 2) }}</h2>
                    <p class="text-xs text-gray-400">Total revenue generated</p>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-green-50 text-[#52930a] text-xs font-bold px-3 py-1 rounded-xl mb-2">
                        {{ $totalSales ?? 0 }} Transactions
                    </span>
                    <div class="w-12 h-12 bg-[#70C116] text-white rounded-2xl flex items-center justify-center ml-auto shadow-md shadow-green-200 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </a>

            <!-- Purchase Overview -->
            <a href="{{ route('purchase-orders.index') }}" class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm hover:shadow-md transition flex items-center justify-between group">
                <div class="space-y-1">
                    <p class="text-sm font-bold text-gray-500">Purchase Overview</p>
                    <h2 class="text-3xl font-black text-gray-900">₱{{ number_format($totalPurchaseCost ?? 0, 2) }}</h2>
                    <p class="text-xs text-gray-400">Total purchase cost</p>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-xl mb-2">
                        {{ $pendingPurchaseOrders ?? 0 }} Pending POs
                    </span>
                    <div class="w-12 h-12 bg-gray-800 text-white rounded-2xl flex items-center justify-center ml-auto shadow-md shadow-gray-200 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- SECONDARY STATS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Ingredients -->
            <a href="{{ route('items.index') }}" class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm hover:shadow-md transition block group">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-bold text-gray-600">Total Ingredients</p>
                    <div class="p-2.5 bg-green-50 text-[#70C116] rounded-xl group-hover:bg-[#70C116] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $totalItems ?? 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Active raw ingredients.</p>
            </a>

            <!-- Menu Items (CLICKABLE NA ITO PAPUNTA SA ITEMS MANAGEMENT) -->
            <a href="{{ route('items.index') }}" class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm hover:shadow-md transition block group">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-bold text-gray-600">Menu Items</p>
                    <div class="p-2.5 bg-green-50 text-[#70C116] rounded-xl group-hover:bg-[#70C116] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $totalMenuItems ?? 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Configured dishes and POS products.</p>
            </a>

            <!-- Sales Transactions -->
            <a href="{{ route('sales.index') }}" class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm hover:shadow-md transition block group">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-bold text-gray-600">Sales Transactions</p>
                    <div class="p-2.5 bg-green-50 text-[#70C116] rounded-xl group-hover:bg-[#70C116] group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $totalSales ?? 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Completed orders captured by POS.</p>
            </a>

            <!-- Waste Records -->
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-bold text-gray-600">Waste Records</p>
                    <div class="p-2.5 bg-green-50 text-[#70C116] rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $totalWaste ?? 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Logged spoilage and kitchen losses.</p>
            </div>

        </div>

        <!-- RECENT SALES TRANSACTIONS & LOW STOCK TABLES -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- RECENT SALES TRANSACTIONS -->
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900">Recent Sales Transactions</h3>
                        <p class="text-xs text-gray-400">List of incoming orders from POS.</p>
                    </div>
                    <a href="{{ route('sales.index') }}" class="text-xs font-bold text-[#70C116] hover:underline">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase">
                                <th class="py-3 px-3">Order ID</th>
                                <th class="py-3 px-3">Customer</th>
                                <th class="py-3 px-3">Amount</th>
                                <th class="py-3 px-3">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                            @forelse($recentSales ?? [] as $sale)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 px-3 text-gray-900 font-bold">#{{ $sale->id }}</td>
                                    <td class="py-3 px-3">{{ $sale->customer_name ?? 'Walk-in Customer' }}</td>
                                    <td class="py-3 px-3 text-[#70C116] font-bold">₱{{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="py-3 px-3 text-xs text-gray-400">{{ $sale->created_at->format('M d, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-400 text-xs">No sales transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- LOW STOCK WARNING LIST -->
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900">Low Stock Warning</h3>
                        <p class="text-xs text-gray-400">Ingredients that need to be reordered.</p>
                    </div>
                    <a href="{{ route('items.index') }}" class="text-xs font-bold text-red-600 hover:underline">View Inventory</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase">
                                <th class="py-3 px-3">Item Name</th>
                                <th class="py-3 px-3">Current Stock</th>
                                <th class="py-3 px-3">Min. Stock</th>
                                <th class="py-3 px-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                            @forelse($lowStockItems ?? [] as $item)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 px-3 text-gray-900 font-bold">{{ $item->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-3 text-red-600 font-bold">
                                        {{ $item->current_stock ?? $item->quantity ?? 0 }} {{ $item->unit ?? '' }}
                                    </td>
                                    <td class="py-3 px-3 text-gray-500">
                                        {{ $item->min_stock ?? 0 }} {{ $item->unit ?? '' }}
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="px-2.5 py-1 text-[10px] font-bold bg-red-100 text-red-700 rounded-full">
                                            Critical
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-400 text-xs">All stocks are currently sufficient.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>