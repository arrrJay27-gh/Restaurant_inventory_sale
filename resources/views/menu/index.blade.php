<x-app-layout>
    <div class="min-h-screen bg-[#F8FAF5] p-8" style="padding-left: 280px;">
        <div class="max-w-7xl mx-auto">
            
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Menu Items</h1>
                    <p class="text-sm font-medium text-gray-500 mt-1">Manage dishes, meals, and products available for ordering.</p>
                </div>

                <!-- Add New Menu Product Button -->
                @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                    <a href="{{ route('menu.create') }}" 
                       class="bg-[#70C116] hover:bg-[#5fa613] text-white px-5 py-3 rounded-2xl font-bold flex items-center gap-2 shadow-sm transition-all hover:shadow-md">
                        <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Add New Menu Product</span>
                    </a>
                @endif
            </div>

            <!-- Menu Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Item 1: Burger -->
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500&q=80" alt="Burger" class="w-full h-48 object-cover">
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900">Burger</h3>
                            <p class="text-[#70C116] font-black text-xl mt-1">₱99.00</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-red-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 2: Fries -->
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <img src="https://images.unsplash.com/photo-1576107232684-1279f390859f?w=500&q=80" alt="Fries" class="w-full h-48 object-cover">
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900">Fries</h3>
                            <p class="text-[#70C116] font-black text-xl mt-1">₱49.00</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-red-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 3: Iced Tea -->
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=500&q=80" alt="Iced Tea" class="w-full h-48 object-cover">
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900">Iced Tea</h3>
                            <p class="text-[#70C116] font-black text-xl mt-1">₱29.00</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-red-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 4: Fried Chicken -->
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <img src="https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=500&q=80" alt="Fried Chicken" class="w-full h-48 object-cover">
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900">Fried Chicken</h3>
                            <p class="text-[#70C116] font-black text-xl mt-1">₱120.00</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-red-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 5: Spaghetti -->
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <img src="https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=500&q=80" alt="Spaghetti" class="w-full h-48 object-cover">
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900">Spaghetti</h3>
                            <p class="text-[#70C116] font-black text-xl mt-1">₱89.00</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-red-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>