<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Purchase Order') }}</h2>
                <p class="mt-1 text-sm text-gray-500">Place stock orders and optionally mark them as received.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('purchase-orders.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Supplier</label>
                        <select name="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                            <option value="ordered" @selected(old('status') === 'ordered')>Ordered</option>
                            <option value="received" @selected(old('status') === 'received')>Received</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Order Items</label>
                        <div id="order-items" class="space-y-4 mt-3">
                            <template id="order-item-row">
                                <div class="grid gap-4 sm:grid-cols-4 items-end">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Item</label>
                                        <select name="items[][item_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Select item</option>
                                            @foreach($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                        <input type="number" step="0.001" name="items[][quantity_ordered]" value="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Unit Cost</label>
                                        <input type="number" step="0.01" name="items[][unit_cost]" value="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" class="remove-order-item inline-flex items-center justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">Remove</button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" id="add-order-item" class="mt-3 inline-flex items-center rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Add item</button>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('purchase-orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Save Purchase Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orderItems = document.getElementById('order-items');
            const addButton = document.getElementById('add-order-item');
            const template = document.getElementById('order-item-row');

            function addRow() {
                const node = template.content.cloneNode(true);
                const removeButton = node.querySelector('.remove-order-item');
                removeButton.addEventListener('click', function () {
                    this.closest('.grid').remove();
                });
                orderItems.appendChild(node);
            }

            addButton.addEventListener('click', addRow);
            addRow();
        });
    </script>
</x-app-layout>
