<x-app-layout>
    <div class="min-h-screen bg-[#F8FAF5] p-8" style="padding-left: 280px;">
        <div class="max-w-3xl mx-auto">
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Add New Menu Product</h1>
                    <p class="text-sm font-medium text-gray-500 mt-1">Fill in the details below to add a new item to your menu.</p>
                </div>
                <a href="{{ route('menu.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-bold text-sm transition-all">
                    ← Back to Menu
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Product Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Product Name</label>
                        <input type="text" name="name" id="name" required placeholder="e.g. Chicken Burger"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:outline-none focus:border-[#70C116] focus:ring-1 focus:ring-[#70C116] transition-all">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-5">
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                        <select name="category" id="category" required
                                class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:outline-none focus:border-[#70C116] focus:ring-1 focus:ring-[#70C116] transition-all">
                            <option value="Food">Food</option>
                            <option value="Drinks">Drinks</option>
                            <option value="Snacks">Snacks</option>
                            <option value="Dessert">Dessert</option>
                        </select>
                        @error('category')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-5">
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Price (₱)</label>
                        <input type="number" step="0.01" name="price" id="price" required placeholder="0.00"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:outline-none focus:border-[#70C116] focus:ring-1 focus:ring-[#70C116] transition-all">
                        @error('price')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Product Image -->
                    <div class="mb-5">
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Product Image File or Image URL</label>
                        <input type="file" name="image_file" id="image_file" accept="image/*"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:outline-none focus:border-[#70C116] transition-all mb-2">
                        <input type="url" name="image_url" id="image_url" placeholder="o kaya mag-paste ng Image URL dito (http://...)"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:outline-none focus:border-[#70C116] focus:ring-1 focus:ring-[#70C116] transition-all">
                        @error('image')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Is Active Toggle -->
                    <div class="mb-8 flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked
                               class="w-5 h-5 text-[#70C116] rounded border-gray-300 focus:ring-[#70C116]">
                        <label for="is_active" class="text-sm font-bold text-gray-700">Available for Ordering</label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('menu.index') }}" 
                           class="px-6 py-3 rounded-2xl font-bold text-gray-500 hover:bg-gray-100 transition-all">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-[#70C116] hover:bg-[#5fa613] text-white px-6 py-3 rounded-2xl font-bold shadow-sm transition-all hover:shadow-md">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>