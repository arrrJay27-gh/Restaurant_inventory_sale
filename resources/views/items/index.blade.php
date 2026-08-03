<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Raw Ingredients Inventory') }}
            </h2>
            <a href="{{ route('items.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-sm">
                + Add Ingredient
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Current Stock</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Min Stock</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Cost/Unit</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($items as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">{{ $item->sku }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->category ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ number_format($item->current_stock, 2) }} <span class="text-xs text-gray-400">{{ $item->unit }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($item->min_stock, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">₱{{ number_format($item->cost_per_unit, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if($item->current_stock <= $item->min_stock)
                                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 animate-pulse">Low Stock</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Healthy</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            <a href="{{ route('items.adjust-stock', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                                ⚙️ Adjust Stock
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
                                            No raw ingredients registered yet. Click "+ Add Ingredient" above to stock your tables!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>