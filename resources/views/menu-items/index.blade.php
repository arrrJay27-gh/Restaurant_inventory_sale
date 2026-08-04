<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        
        <!-- Kaliwang Bahagi: Form para mag-add ng bagong Menu Item -->
        <div class="bg-white rounded-lg shadow-sm p-6 h-fit">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Add POS Menu Item</h3>
            
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('menu-items.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                    <input type="text" name="name" required placeholder="e.g., Wintermelon Milk Tea" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <input type="text" name="category" placeholder="e.g., Milk Tea Series" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Selling Price (PHP)</label>
                    <input type="number" name="price" step="0.01" min="0" required placeholder="0.00" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition font-medium">
                    Save to POS Menu
                </button>
            </form>
        </div>

        <!-- Kanang Bahagi: Talahanayan ng mga Kasalukuyang Produkto sa POS -->
        <div class="md:grid md:col-span-2 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Current POS Products</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b text-gray-500 font-medium bg-gray-50">
                            <th class="py-3 px-4">NAME</th>
                            <th class="py-3 px-4">CATEGORY</th>
                            <th class="py-3 px-4 text-right">PRICE</th>
                            <th class="py-3 px-4 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menuItems as $item)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4 font-medium text-gray-900">{{ $item->name }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $item->category ?? 'General' }}</td>
                                <td class="py-3 px-4 text-right font-semibold text-gray-900">₱{{ number_format($item->price, 2) }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">Active</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">No products registered in POS.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $menuItems->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
