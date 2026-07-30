<nav class="bg-white border-r border-gray-200 fixed inset-y-0 left-0 w-64 hidden md:block">
    <div class="h-full px-4 py-6 overflow-y-auto">
        <div class="flex items-center mb-8">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <x-application-logo class="h-8 w-auto text-gray-800" />
                <span class="text-lg font-semibold text-gray-900">{{ config('app.name', 'Inventory') }}</span>
            </a>
        </div>

        <div class="space-y-2">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-nav-link>
            <x-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">{{ __('Inventory') }}</x-nav-link>
            <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">{{ __('Suppliers') }}</x-nav-link>
            <x-nav-link :href="route('purchase-orders.index')" :active="request()->routeIs('purchase-orders.*')">{{ __('Purchase Orders') }}</x-nav-link>
            <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">{{ __('Sales') }}</x-nav-link>
            <x-nav-link :href="route('waste-logs.create')" :active="request()->routeIs('waste-logs.*')">{{ __('Waste Logs') }}</x-nav-link>
        </div>

        <div class="mt-8 border-t pt-4">
            <div class="text-sm text-gray-600">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
            <div class="mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile top nav -->
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 md:hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="ms-3 flex items-center">
                    <x-application-logo class="h-8 w-auto" />
                </a>
            </div>

            <div class="flex items-center">
                <div class="text-sm text-gray-600">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">{{ __('Inventory') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">{{ __('Suppliers') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('purchase-orders.index')" :active="request()->routeIs('purchase-orders.*')">{{ __('Purchase Orders') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">{{ __('Sales') }}</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
