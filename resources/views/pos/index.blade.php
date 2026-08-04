<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-slate-100 h-screen flex flex-col font-sans" x-data="posSystem()">

    <!-- Header -->
    <header class="bg-slate-900 text-white px-6 py-4 shadow-md flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <h1 class="text-xl font-bold tracking-wide">Our Menu</h1>
        </div>

        <!-- Header Actions & Navigation -->
        <div class="flex items-center space-x-3">
            <div class="text-xs bg-slate-800 text-slate-300 px-3 py-1.5 rounded-full border border-slate-700 hidden sm:block">
                System Online
            </div>

            <!-- Back to Landing Page / Home -->
            <a href="{{ url('/') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs px-3 py-1.5 rounded-lg border border-slate-700 font-semibold transition flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Home</span>
            </a>

            <!-- Direct Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600/80 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded-lg font-semibold transition flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- Menu Grid (Left) -->
        <div class="w-2/3 p-6 overflow-y-auto">
            <h2 class="text-lg font-bold text-slate-700 mb-4">Food & Drinks</h2>

            <div class="grid grid-cols-3 gap-5">
                @forelse($menuItems as $item)
                    @php
                        // Specific Unsplash fallback image matching based on item name
                        $name = strtolower($item->name);
                        $defaultImage = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=80';

                        if (str_contains($name, 'burger')) {
                            $defaultImage = 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=400&q=80';
                        } elseif (str_contains($name, 'fries')) {
                            $defaultImage = 'https://images.unsplash.com/photo-1576107232684-1279f390859f?auto=format&fit=crop&w=400&q=80';
                        } elseif (str_contains($name, 'tea') || str_contains($name, 'iced')) {
                            $defaultImage = 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=400&q=80';
                        } elseif (str_contains($name, 'chicken')) {
                            $defaultImage = 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?auto=format&fit=crop&w=400&q=80';
                        } elseif (str_contains($name, 'spaghetti') || str_contains($name, 'pasta')) {
                            $defaultImage = 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=400&q=80';
                        }

                        $imageUrl = $item->image ? asset('storage/' . $item->image) : $defaultImage;
                    @endphp

                    <div @click="addToCart({{ json_encode($item) }})" 
                         class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-200 border border-slate-200 overflow-hidden cursor-pointer flex flex-col justify-between hover:-translate-y-1">
                        
                        <!-- Image Container -->
                        <div class="h-36 w-full bg-slate-100 overflow-hidden relative">
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.onerror=null; this.src='{{ $defaultImage }}';">
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>

                        <!-- Info Area -->
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base group-hover:text-emerald-600 transition-colors line-clamp-1">
                                    {{ $item->name }}
                                </h3>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-emerald-600 font-extrabold text-lg">₱{{ number_format($item->price, 2) }}</span>
                                <span class="text-xs bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-1 rounded-full border border-emerald-200">
                                    + Add
                                </span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 bg-white p-12 rounded-2xl text-center text-slate-400 border border-slate-200 shadow-sm">
                        No menu items found in the database.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Cart Sidebar (Right) -->
        <div class="w-1/3 bg-white border-l border-slate-200 p-6 flex flex-col justify-between shadow-lg">
            <div>
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <h2 class="text-xl font-bold text-slate-800">Current Order</h2>
                    <span class="text-xs bg-slate-100 text-slate-600 font-bold px-2.5 py-1 rounded-full" x-text="`${cart.length} items`"></span>
                </div>
                
                <!-- When Cart is Empty -->
                <template x-if="cart.length === 0">
                    <div class="flex flex-col items-center justify-center py-16 text-slate-300">
                        <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="text-sm font-medium text-slate-400">Your cart is empty.</p>
                    </div>
                </template>

                <!-- Item List -->
                <div class="space-y-3 overflow-y-auto max-h-[50vh] pr-1">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition">
                            <div class="pr-2">
                                <h4 class="font-bold text-slate-800 text-sm" x-text="item.name"></h4>
                                <span class="text-xs text-slate-500 font-medium" x-text="`₱${Number(item.price).toFixed(2)} x ${item.quantity}`"></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="updateQty(item.id, -1)" class="w-8 h-8 bg-white hover:bg-slate-200 text-slate-700 font-bold rounded-lg border border-slate-200 flex items-center justify-center transition shadow-sm">-</button>
                                <span class="font-bold text-slate-800 text-sm min-w-[20px] text-center" x-text="item.quantity"></span>
                                <button @click="updateQty(item.id, 1)" class="w-8 h-8 bg-white hover:bg-slate-200 text-slate-700 font-bold rounded-lg border border-slate-200 flex items-center justify-center transition shadow-sm">+</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Total and Checkout Button -->
            <div class="border-t border-slate-200 pt-4">
                <div class="flex justify-between items-baseline mb-4">
                    <span class="text-slate-600 font-medium">Total Amount:</span>
                    <span class="text-2xl font-black text-slate-900" x-text="`₱${totalPrice()}`"></span>
                </div>
                
                <button @click="checkout()" 
                        :disabled="cart.length === 0 || loading"
                        :class="cart.length === 0 || loading ? 'bg-slate-300 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/30'"
                        class="w-full text-white py-3.5 rounded-xl font-bold transition-all duration-200 flex justify-center items-center">
                    <span x-show="!loading">Pay (Checkout)</span>
                    <span x-show="loading" class="animate-pulse">Processing...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Alpine.js Logic -->
    <script>
        function posSystem() {
            return {
                cart: [],
                loading: false,

                addToCart(product) {
                    let existing = this.cart.find(i => i.id === product.id);
                    if (existing) {
                        existing.quantity++;
                    } else {
                        this.cart.push({ 
                            id: product.id, 
                            name: product.name, 
                            price: parseFloat(product.price), 
                            quantity: 1 
                        });
                    }
                },

                updateQty(id, change) {
                    let item = this.cart.find(i => i.id === id);
                    if (item) {
                        item.quantity += change;
                        if (item.quantity <= 0) {
                            this.cart = this.cart.filter(i => i.id !== id);
                        }
                    }
                },

                totalPrice() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2);
                },

                async checkout() {
                    if (this.cart.length === 0) return alert('Your cart is empty');
                    
                    this.loading = true;

                    const formattedCart = this.cart.map(item => ({
                        id: item.id,
                        price: parseFloat(item.price),
                        quantity: parseInt(item.quantity)
                    }));

                    try {
                        let response = await fetch('/pos/checkout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ cart: formattedCart })
                        });

                        let data = await response.json();

                        if (response.ok && data.success) {
                            alert(data.message || 'Order placed successfully!');
                            this.cart = [];
                            location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'An error occurred on the server.'));
                        }
                    } catch (error) {
                        alert('Error: Failed to connect to the server.');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>