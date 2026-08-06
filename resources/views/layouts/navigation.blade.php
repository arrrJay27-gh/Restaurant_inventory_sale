<div class="relative flex" x-data="{ open: true }">
    <!-- Sidebar -->
    <aside 
        :class="open ? 'w-64' : 'w-20'" 
        class="fixed top-0 left-0 h-screen bg-white border-r border-gray-100 flex flex-col justify-between p-4 transition-all duration-300 z-50">
        
        <div>
            <!-- Header Logo & Toggle Button -->
            <div class="flex items-center justify-between mb-8 px-2">
                <div class="flex items-center gap-3" x-show="open">
                    <div class="w-10 h-10 rounded-2xl bg-[#70C116] text-white font-black flex items-center justify-center text-xl">
                        F
                    </div>
                    <span class="font-extrabold text-xl text-gray-900 tracking-wider">FLAVOURS</span>
                </div>

                <!-- Toggle Button -->
                <button @click="open = !open" class="p-2 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-[#70C116] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    <span x-show="open" class="whitespace-nowrap">Dashboard</span>
                </a>

                <!-- Inventory Link (Raw Ingredients) -->
                <a href="{{ route('inventory.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('inventory.*') ? 'bg-[#70C116] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span x-show="open" class="whitespace-nowrap">Inventory</span>
                </a>

                <!-- Menu Items Link -->
                <a href="{{ route('menu.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('menu.*') ? 'bg-[#70C116] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span x-show="open" class="whitespace-nowrap">Menu Items</span>
                </a>

                <!-- Purchase Orders -->
                <a href="{{ route('purchase-orders.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('purchase-orders.*') ? 'bg-[#70C116] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span x-show="open" class="whitespace-nowrap">Purchase Orders</span>
                </a>

                <!-- Sales -->
                <a href="{{ route('sales.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('sales.*') ? 'bg-[#70C116] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span x-show="open" class="whitespace-nowrap">Sales</span>
                </a>
            </nav>
        </div>

        <!-- Profile Footer -->
        <div class="bg-gray-50 p-3 rounded-2xl flex items-center justify-between" x-show="open">
            <div>
                <div class="font-bold text-xs text-gray-900 leading-tight">{{ Auth::user()->name ?? 'julius mirano' }}</div>
                <div class="text-[10px] font-semibold text-[#70C116] capitalize">{{ Auth::user()->role ?? 'admin' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-400 hover:text-red-600 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </aside>
</div>