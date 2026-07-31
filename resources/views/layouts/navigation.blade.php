<!-- TOP BAR: Sapilitang naka-lock gamit ang inline CSS para hindi kailanman sumama sa scroll -->
<nav x-data="{ open: false }" 
     class="bg-white border-b border-gray-200 z-50 shadow-sm" 
     style="position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; height: 64px !important;">
    
    <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between" style="height: 100%;">
        
        <!-- KALIWANG BAHAGI: Hamburger Button at Logo -->
        <div class="flex items-center space-x-4">
            <!-- Hamburger Toggle Button -->
            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Brand Logo at Pangalan -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <x-application-logo class="h-6 w-auto text-violet-600" />
                <span class="text-sm font-bold text-gray-900 tracking-tight">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>

        <!-- KANANG BAHAGI: Pangalan ng User -->
        <div class="text-right hidden sm:block">
            <p class="text-xs font-semibold text-gray-800 leading-none" style="margin: 0;">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-gray-400 mt-1 leading-none" style="margin: 4px 0 0 0;">Inventory Manager</p>
        </div>
    </div>

    <!-- DROPDOWN BOX: Nakaposisyon nang tama sa ilalim ng fixed header -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.away="open = false" 
         class="bg-white border border-gray-200 rounded-lg shadow-xl py-2 z-50"
         style="position: absolute !important; top: 64px !important; left: 16px !important; width: 240px;">
        
        <!-- Lahat ng Links sa Loob ng Hamburger -->
        <div class="space-y-0.5 px-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('dashboard') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                {{ __('Dashboard') }}
            </a>

            <a href="/items" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->is('items*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                {{ __('Inventory') }}
            </a>

            <a href="/suppliers" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->is('suppliers*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                {{ __('Suppliers') }}
            </a>

            <a href="/stocks" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->is('stocks*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                {{ __('Stocks') }}
            </a>

            <a href="/purchase-orders" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->is('purchase-orders*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                {{ __('Purchase Orders') }}
            </a>

            <a href="/sales" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->is('sales*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                {{ __('Sales') }}
            </a>

            <a href="/waste-logs/create" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->is('waste-logs*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                {{ __('Waste Logs') }}
            </a>
        </div>

        <!-- Logout Trigger sa Loob ng Hamburger Dropdown -->
        <div class="mt-2 pt-2 border-t border-gray-100 px-4 bg-gray-50/50 rounded-b-lg">
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="w-full text-left text-xs font-semibold text-red-600 hover:text-red-700 transition">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</nav>