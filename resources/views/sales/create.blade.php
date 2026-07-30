<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Sale') }}</h2>
                <p class="mt-1 text-sm text-gray-500">Record a sale and update inventory automatically.</p>
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

                <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Order Type</label>
                            <select name="order_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="counter" @selected(old('order_type') === 'counter')>Counter</option>
                                <option value="delivery" @selected(old('order_type') === 'delivery')>Delivery</option>
                                <option value="pickup" @selected(old('order_type') === 'pickup')>Pickup</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <input type="text" name="payment_method" value="{{ old('payment_method') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sale Items</label>
                        <div id="sale-items" class="space-y-4 mt-3"></div>
                        <button type="button" id="add-sale-item" class="mt-3 inline-flex items-center rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Add item</button>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-slate-600">Order total</p>
                            <p class="text-2xl font-semibold text-slate-900" id="order-total">0.00</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('sales.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Save Sale</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="sale-item-row">
        <div class="sale-row grid gap-4 sm:grid-cols-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Menu Item</label>
                <select name="items[][menu_item_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Select item</option>
                    @foreach($menuItems as $menuItem)
                        <option value="{{ $menuItem->id }}" data-price="{{ number_format($menuItem->price, 2, '.', '') }}">{{ $menuItem->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" step="1" name="items[][quantity]" value="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                <input type="number" step="0.01" name="items[][unit_price]" value="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="remove-sale-item inline-flex items-center justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">Remove</button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const saleItems = document.getElementById('sale-items');
            const addButton = document.getElementById('add-sale-item');
            const template = document.getElementById('sale-item-row');
            const orderTotal = document.getElementById('order-total');

            function calculateTotal() {
                let total = 0;
                saleItems.querySelectorAll('.sale-row').forEach(row => {
                    const qty = parseFloat(row.querySelector('[name*="[quantity]"]').value) || 0;
                    const price = parseFloat(row.querySelector('[name*="[unit_price]"]').value) || 0;
                    total += qty * price;
                });
                orderTotal.textContent = total.toFixed(2);
            }

            function addRow() {
                const node = template.content.cloneNode(true);
                const row = node.querySelector('.sale-row');
                const removeButton = node.querySelector('.remove-sale-item');
                const itemSelect = row.querySelector('[name*="[menu_item_id]"]');
                const priceInput = row.querySelector('[name*="[unit_price]"]');
                const quantityInput = row.querySelector('[name*="[quantity]"]');

                itemSelect.addEventListener('change', function () {
                    const selected = this.selectedOptions[0];
                    priceInput.value = selected.dataset.price || '0.00';
                    calculateTotal();
                });

                quantityInput.addEventListener('input', calculateTotal);
                priceInput.addEventListener('input', calculateTotal);

                removeButton.addEventListener('click', function () {
                    this.closest('.sale-row').remove();
                    calculateTotal();
                });

                saleItems.appendChild(node);
            }

            addButton.addEventListener('click', addRow);
            addRow();
        });
    </script>
</x-app-layout>
