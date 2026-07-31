<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">🍽️ Restaurant POS Dashboard</h1>
                <p class="text-sm text-gray-500">Real-time sales monitoring and point-of-sale management</p>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex gap-3">
                <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium shadow transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                    Open POS Terminal
                </a>
            </div>
        </div>

        <!-- Metric Cards Grid (3 Columns) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Card 1: Today's Sales -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Benta Ngayong Araw</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-1">₱{{ number_format($todaySales ?? 0, 2) }}</h2>
                    <span class="text-xs text-green-600 font-medium inline-flex items-center mt-2">
                        ↑ Updated live
                    </span>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Card 2: Today's Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Mga Order Ngayong Araw</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $todayOrdersCount ?? 0 }}</h2>
                    <span class="text-xs text-gray-500 font-medium inline-flex items-center mt-2">
                        Total completed orders
                    </span>
                </div>
                <div class="p-3 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
            </div>

            <!-- Card 3: Active Menu Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active Menu Items</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalMenuItems ?? 0 }}</h2>
                    <span class="text-xs text-indigo-600 font-medium inline-flex items-center mt-2">
                        Available in POS
                    </span>
                </div>
                <div class="p-3 bg-amber-50 rounded-lg text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>

        </div>

        <!-- Management & Shortcuts Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">⚙️ POS Management Shortcuts</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                
                <a href="{{ route('pos.index') }}" class="p-4 rounded-xl border border-gray-200 hover:border-indigo-500 hover:bg-indigo-50/50 transition-all text-left group">
                    <div class="text-indigo-600 font-semibold mb-1 group-hover:translate-x-1 transition-transform">🛒 Cashier POS →</div>
                    <p class="text-xs text-gray-500">Open register for placing customer orders.</p>
                </a>

                <a href="/sales" class="p-4 rounded-xl border border-gray-200 hover:border-green-500 hover:bg-green-50/50 transition-all text-left group">
                    <div class="text-green-600 font-semibold mb-1 group-hover:translate-x-1 transition-transform">📄 Sales History →</div>
                    <p class="text-xs text-gray-500">View transactions and receipt logs.</p>
                </a>

                <a href="/items" class="p-4 rounded-xl border border-gray-200 hover:border-amber-500 hover:bg-amber-50/50 transition-all text-left group">
                    <div class="text-amber-600 font-semibold mb-1 group-hover:translate-x-1 transition-transform">🍔 Menu Management →</div>
                    <p class="text-xs text-gray-500">Update prices and dish availability.</p>
                </a>

                <a href="/waste-logs" class="p-4 rounded-xl border border-gray-200 hover:border-red-500 hover:bg-red-50/50 transition-all text-left group">
                    <div class="text-red-600 font-semibold mb-1 group-hover:translate-x-1 transition-transform">🗑️ Waste Logs →</div>
                    <p class="text-xs text-gray-500">Track expired or spoiled ingredients.</p>
                </a>

            </div>
        </div>

    </div>
</x-app-layout>