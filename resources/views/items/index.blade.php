<x-app-layout>
    <!-- Ginamitan ng style margin-left para sigurado at ma-override ang kahit anong layout issue -->
    <div style="margin-left: 280px; padding: 2rem;" class="min-h-screen bg-[#F6FAF3]">
        
        <!-- Header & Top Navigation -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-[#1A2E12] leading-tight">
                    {{ __('Inventory Items') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Manage raw ingredients and stock items.
                </p>
            </div>

            <div class="flex items-center gap-4">
                <!-- Add Item Button -->
                <a href="{{ route('items.create') }}" 
                   class="bg-[#70C116] hover:bg-[#5fa810] text-white font-bold px-5 py-2.5 rounded-2xl shadow-sm transition-all text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Item
                </a>

                <!-- User Profile Badge -->
                <div class="bg-white p-2 pr-5 rounded-2xl border border-green-100 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#70C116] text-white font-black flex items-center justify-center text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'JU', 0, 2)) }}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-gray-900 leading-tight">{{ Auth::user()->name ?? 'julius mirano' }}</div>
                        <div class="text-[11px] font-semibold text-[#70C116] capitalize">{{ Auth::user()->role ?? 'admin' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-2xl text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Inventory Table Container -->
        <div class="bg-white rounded-3xl border border-green-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-4 px-6">Name</th>
                            <th class="py-4 px-6">SKU</th>
                            <th class="py-4 px-6">Stock</th>
                            <th class="py-4 px-6">Min Stock</th>
                            <th class="py-4 px-6">Cost / Unit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-900">{{ $item->name }}</td>
                                <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $item->sku }}</td>
                                <td class="py-4 px-6">
                                    {{ $item->current_stock ?? $item->quantity }} {{ $item->unit }}
                                </td>
                                <td class="py-4 px-6 text-gray-500">{{ $item->min_stock }} {{ $item->unit }}</td>
                                <td class="py-4 px-6">₱{{ number_format($item->cost_per_unit ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400 font-medium">
                                    No inventory items found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($items, 'links'))
                <div class="p-4 border-t border-gray-50">
                    {{ $items->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>