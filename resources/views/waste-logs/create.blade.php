<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('waste-logs.store') }}" method="POST">
            @csrf
            
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Waste Log</h3>

                <div id="items-container">
                    <!-- Dynamic Row Item -->
                    <div class="waste-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 items-end border-b pb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Menu Item</label>
                            <select name="items[0][menu_item_id]" class="menu-item-select mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Select item</option>
                                @foreach($menuItems as $menuItem)
                                    <option value="{{ $menuItem->id }}" data-price="{{ $menuItem->price ?? 0 }}">
                                        {{ $menuItem->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="items[0][quantity]" value="1" min="1" class="item-qty mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                            <input type="number" step="0.01" name="items[0][unit_price]" value="0.00" class="item-price mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <button type="button" class="remove-item bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Remove</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" id="add-item" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Add item</button>
                </div>

                <!-- Order Total Box -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-700">Order total</span>
                    <span id="order-total" class="text-2xl font-bold text-gray-900">0.00</span>
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('waste-logs.create') }}" class="px-4 py-2 border rounded-md text-gray-600">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Save Waste Log</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let rowIndex = 0;

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.waste-item').forEach(row => {
                const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                total += qty * price;
            });
            document.getElementById('order-total').innerText = total.toFixed(2);
        }

        document.getElementById('add-item').addEventListener('click', function () {
            rowIndex++;
            const container = document.getElementById('items-container');
            const firstRow = container.querySelector('.waste-item');
            const newRow = firstRow.cloneNode(true);

            // Update field names indices
            newRow.querySelectorAll('input, select').forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${rowIndex}]`);
                if(input.tagName === 'SELECT') input.value = '';
                if(input.classList.contains('item-qty')) input.value = 1;
                if(input.classList.contains('item-price')) input.value = '0.00';
            });

            container.appendChild(newRow);
        });

        document.addEventListener('input', function (e) {
            if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
                calculateTotal();
            }
        });

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('menu-item-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const price = selectedOption.getAttribute('data-price') || 0;
                const row = e.target.closest('.waste-item');
                row.querySelector('.item-price').value = parseFloat(price).toFixed(2);
                calculateTotal();
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                if (document.querySelectorAll('.waste-item').length > 1) {
                    e.target.closest('.waste-item').remove();
                    calculateTotal();
                }
            }
        });
    </script>
    @endpush
</x-app-layout>