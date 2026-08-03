<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Stock: {{ $item->name }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-gray-100">
                <p class="text-sm text-gray-500 mb-4">Current Registered Stock: <strong class="text-gray-900">{{ $item->current_stock }} {{ $item->unit }}</strong></p>
                
                <form action="{{ route('items.update-stock', $item->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Transaction Type</label>
                        <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="IN">📈 Stock In (Add to inventory)</option>
                            <option value="OUT">📉 Stock Out (Reduce inventory)</option>
                            <option value="ADJUSTMENT">🔄 Manual Overwrite (Set exact count)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity ({{ $item->unit }})</label>
                        <input type="number" step="0.01" name="quantity" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reason / Reference Notes</label>
                        <input type="text" name="reason" placeholder="e.g., Delivery from supplier, audit correction" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('items.index') }}" class="bg-gray-100 px-4 py-2 text-sm rounded-md text-gray-700">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-md font-medium shadow-sm transition">Apply Stock Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
