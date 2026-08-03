<!-- SIDEBAR NAVIGATION -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col">
    <!-- Brand Logo / Header -->
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-6 w-auto text-violet-600" />
            <span class="text-sm font-bold text-gray-900 tracking-tight">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('dashboard') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            {{ __('Dashboard') }}
        </a>

        <!-- POS System Link -->
        <a href="{{ route('pos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('pos.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            {{ __('POS System') }}
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

    <!-- User Profile & Logout saibaba ng Sidebar -->
    <div class="p-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between mb-3">
            <div>
                <p class="text-xs font-semibold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gray-400 mt-1">Inventory Manager</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left text-xs font-semibold text-red-600 hover:text-red-700 transition">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</aside>