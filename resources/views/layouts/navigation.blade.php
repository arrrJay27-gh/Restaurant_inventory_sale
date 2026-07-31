<aside :class="open ? 'w-80' : 'w-24'" 
       class="bg-white border-r border-gray-200 flex flex-col justify-between h-screen sticky top-0 left-0 z-40 transition-all duration-300 flex-shrink-0 shadow-sm"
       style="box-sizing: border-box;">
    
    <div class="flex-1 flex flex-col min-h-0" style="padding: 28px 16px 16px 16px;">
        
        <div class="flex items-center flex-shrink-0" 
             :class="open ? 'justify-between' : 'justify-center'" 
             style="margin-bottom: 44px; padding-left: 8px; padding-right: 8px;">
            
            <div class="flex items-center space-x-3" x-show="open" x-transition:enter="transition ease-out duration-200">
                <x-application-logo class="h-7 w-auto text-violet-600" />
                <span class="text-base font-bold text-gray-900 tracking-tight" style="white-space: nowrap;">
                    {{ config('app.name', 'Laravel') }}
                </span>
            </div>
            
            <!-- Collapsible Expand/Minimize Action Button -->
            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none transition-colors border border-gray-100 shadow-sm bg-gray-50/50">
                <svg :class="{'rotate-180': !open}" class="h-5 w-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </div>
        
        <!-- SIDEBAR NAVIGATION MENU LINKS: Sapilitang nilagyan ng 12px margin separation gap sa bawat a-tag block -->
        <nav class="flex-1 overflow-y-auto overflow-x-hidden pr-1" style="display: flex; flex-direction: column;">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-4 mt-4 mb-2">Supply Chain</p>
            <a href="{{ route('dashboard') }}" 
               class="flex items-center text-sm font-bold rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-violet-600 text-white shadow-lg shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" 
               :class="open ? 'justify-start space-x-4' : 'justify-center'"
               style="padding: 14px 18px; margin-bottom: 12px; border-width: 1px; border-color: transparent;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">📊</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Dashboard') }}</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
    <span>📊 POS Dashboard</span>
</a>

            <a href="/items" 
               class="flex items-center text-sm font-bold rounded-xl transition-all {{ request()->is('items*') ? 'bg-violet-600 text-white shadow-lg shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" 
               :class="open ? 'justify-start space-x-4' : 'justify-center'"
               style="padding: 14px 18px; margin-bottom: 12px; border-width: 1px; border-color: transparent;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">📦</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Raw Ingredients') }}</span>
            </a>

            <a href="/suppliers" 
               class="flex items-center text-sm font-bold rounded-xl transition-all {{ request()->is('suppliers*') ? 'bg-violet-600 text-white shadow-lg shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" 
               :class="open ? 'justify-start space-x-4' : 'justify-center'"
               style="padding: 14px 18px; margin-bottom: 12px; border-width: 1px; border-color: transparent;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">🤝</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Suppliers') }}</span>
            </a>

            <a href="/stocks" 
               class="flex items-center text-sm font-bold rounded-xl transition-all {{ request()->is('stocks*') ? 'bg-violet-600 text-white shadow-lg shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" 
               :class="open ? 'justify-start space-x-4' : 'justify-center'"
               style="padding: 14px 18px; margin-bottom: 12px; border-width: 1px; border-color: transparent;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">📈</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Stocks') }}</span>
            </a>

            <a href="/purchase-orders" 
               class="flex items-center text-sm font-bold rounded-xl transition-all {{ request()->is('purchase-orders*') ? 'bg-violet-600 text-white shadow-lg shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" 
               :class="open ? 'justify-start space-x-4' : 'justify-center'"
               style="padding: 14px 18px; margin-bottom: 12px; border-width: 1px; border-color: transparent;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">📜</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Purchase Orders') }}</span>
            </a>

            <a href="/sales" 
               class="flex items-center text-sm font-bold rounded-xl transition-all {{ request()->is('sales*') ? 'bg-violet-600 text-white shadow-lg shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" 
               :class="open ? 'justify-start space-x-4' : 'justify-center'"
               style="padding: 14px 18px; margin-bottom: 12px; border-width: 1px; border-color: transparent;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">💰</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Sales') }}</span>
            </a>

            <a href="/waste-logs/create" 
               class="flex items-center text-sm font-bold rounded-xl transition-all {{ request()->is('waste-logs*') ? 'bg-violet-600 text-white shadow-lg shadow-violet-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" 
               :class="open ? 'justify-start space-x-4' : 'justify-center'"
               style="padding: 14px 18px; margin-bottom: 12px; border-width: 1px; border-color: transparent;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">🗑️</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Waste Logs') }}</span>
            </a>
        </nav>
    </div>

    <!-- LOWER FOOTER PROFILE ZONE: Nilagyan ng malaking padding at isolation boundaries -->
    <div class="border-t border-gray-100 bg-gray-50/50 flex-shrink-0" style="padding: 24px 20px;">
        <div class="mb-5" x-show="open" style="padding-left: 4px;">
            <p class="text-sm font-bold text-gray-800 truncate" style="margin: 0; line-height: 1.4; max-width: 100%;">{{ Auth::user()->name }}</p>
            <p class="text-xs font-medium text-gray-400 style=margin: 4px 0 0 0; line-height: 1;">Inventory Manager</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" 
                    class="w-full text-sm font-bold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition flex items-center border border-transparent" 
                    :class="open ? 'justify-start space-x-4' : 'justify-center'"
                    style="padding: 12px 16px;">
                <span class="text-xl flex-shrink-0" style="display: inline-block; line-height: 1;">🚪</span>
                <span x-show="open" style="white-space: nowrap;">{{ __('Log Out') }}</span>
            </button>
        </form>
    </div>
</aside>
