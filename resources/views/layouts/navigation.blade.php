<!-- PERMANENT COLLAPSIBLE SIDEBAR: Lalabas sa kahit anong sukat ng screen at naka-lock laban sa scroll -->
<aside :class="open ? 'w-64' : 'w-20'" 
       class="bg-white border-r border-gray-200 flex flex-col justify-between fixed top-0 bottom-0 left-0 z-40 transition-all duration-300 shadow-sm">
    
    <div class="px-3 py-5 flex-1 flex flex-col min-h-0">
        <!-- SIDEBAR HEADER: Switch toggle button at App Logo -->
        <div class="flex items-center mb-8 px-2 flex-shrink-0" :class="open ? 'justify-between' : 'justify-center'">
            <div class="flex items-center space-x-2.5" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                <x-application-logo class="h-6 w-auto text-violet-600" />
                <span class="text-sm font-bold text-gray-900 tracking-tight" style="white-space: nowrap;">
                    {{ config('app.name', 'Laravel') }}
                </span>
            </div>
            
            <!-- Collapsible Action Button: Pinapaliit o pinalalaki ang sidebar menu -->
            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none transition-colors">
                <svg :class="{'rotate-180': !open}" class="h-5 w-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </div>
        
        <!-- SIDEBAR NAVIGATION MENU LINKS (May mga kasamang visual emojis/icons) -->
        <nav class="space-y-1.5 flex-1 overflow-y-auto overflow-x-hidden pr-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-violet-600 text-white shadow-md shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-lg flex-shrink-0">📊</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Dashboard') }}</span>
            </a>

            <a href="/items" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('items*') ? 'bg-violet-600 text-white shadow-md shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-lg flex-shrink-0">📦</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Inventory') }}</span>
            </a>

            <a href="/suppliers" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('suppliers*') ? 'bg-violet-600 text-white shadow-md shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-lg flex-shrink-0">🤝</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Suppliers') }}</span>
            </a>

            <a href="/stocks" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('stocks*') ? 'bg-violet-600 text-white shadow-md shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-lg flex-shrink-0">📈</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Stocks') }}</span>
            </a>

            <a href="/purchase-orders" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('purchase-orders*') ? 'bg-violet-600 text-white shadow-md shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-lg flex-shrink-0">📜</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Orders') }}</span>
            </a>

            <a href="/sales" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('sales*') ? 'bg-violet-600 text-white shadow-md shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-lg flex-shrink-0">💰</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Sales') }}</span>
            </a>

            <a href="/waste-logs/create" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('waste-logs*') ? 'bg-violet-600 text-white shadow-md shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-lg flex-shrink-0">🗑️</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Waste Logs') }}</span>
            </a>
        </nav>
    </div>

    <!-- SIDEBAR FOOTER: Impormasyon ng User at Logout Button sa pinakailalim -->
    <div class="p-3 border-t border-gray-100 bg-gray-50/50 flex-shrink-0">
        <div class="px-2 mb-3" x-show="open">
            <p class="text-xs font-semibold text-gray-800 truncate leading-tight">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-gray-400 mt-1 leading-none">Inventory Manager</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="w-full text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 p-2.5 rounded-xl transition flex items-center" :class="open ? 'justify-start space-x-3' : 'justify-center'">
                <span class="text-sm flex-shrink-0">🚪</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Log Out') }}</span>
            </button>
        </form>
    </div>
</aside>
