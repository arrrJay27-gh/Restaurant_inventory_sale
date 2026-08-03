<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Generate Supply Purchase Invoice</h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-gray-100">
                <form action="{{ route('purchase_orders.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Select Vendor Supplier *</label>
                        <select name="supplier_id" required class="mt-1 block w-full px-3 py-2 bg-white rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="" disabled selected>-- Choose Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Ingredient Item *</label>
                            <select name="item_id" required class="mt-1 block w-full px-3 py-2 bg-white rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="" disabled selected>-- Choose Item --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->unit }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Order Quantity *</label>
                            <input type="number" step="0.01" name="quantity_ordered" required class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit Cost Price *</label>
                            <input type="number" step="0.01" name="unit_cost" required class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Internal Reference Notes</label>
                        <textarea name="notes" rows="2" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="e.g., Weekly automated meat re-order dispatch"></textarea>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('purchase_orders.index') }}" class="bg-gray-100 px-4 py-2 text-sm rounded-md text-gray-700">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-md font-medium shadow-sm transition">Dispatch Purchase Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>