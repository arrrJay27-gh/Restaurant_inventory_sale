<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 h-screen flex flex-col" x-data="posSystem()">

    <header class="bg-slate-900 text-white p-4 shadow flex justify-between items-center">
        <h1 class="text-xl font-bold">Restaurant POS & Inventory</h1>
    </header>

    <div class="flex-1 flex overflow-hidden">
        <!-- Menu Grid -->
        <div class="w-2/3 p-6 overflow-y-auto grid grid-cols-3 gap-4">
            @foreach($menuItems as $item)
                <div @click="addToCart({{ $item }})" class="bg-white p-4 rounded-xl shadow cursor-pointer hover:bg-slate-50 border border-slate-200 flex flex-col justify-between">
                    <h3 class="font-bold text-lg text-slate-800">{{ $item->name }}</h3>
                    <span class="text-emerald-600 font-semibold mt-4">₱{{ number_format($item->price, 2) }}</span>
                </div>
            @endforeach
        </div>

        <!-- Cart Sidebar -->
        <div class="w-1/3 bg-white border-l border-slate-200 p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 mb-4">Kasalukuyang Order</h2>
                <template x-if="cart.length === 0">
                    <p class="text-slate-400">Walang laman ang cart.</p>
                </template>
                <div class="space-y-3 overflow-y-auto max-h-[50vh]">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <h4 class="font-semibold text-slate-700" x-text="item.name"></h4>
                                <span class="text-xs text-slate-500" x-text="`₱${item.price} x ${item.quantity}`"></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button @click="updateQty(item.id, -1)" class="px-2 bg-gray-200 rounded">-</button>
                                <span x-text="item.quantity"></span>
                                <button @click="updateQty(item.id, 1)" class="px-2 bg-gray-200 rounded">+</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="border-t pt-4">
                <div class="flex justify-between text-lg font-bold mb-4">
                    <span>Kabuuang Bayarin:</span>
                    <span x-text="`₱${totalPrice()}`"></span>
                </div>
                <button @click="checkout()" class="w-full bg-emerald-600 text-white py-3 rounded-lg font-bold hover:bg-emerald-700 transition">Bayaran (Checkout)</button>
            </div>
        </div>
    </div>

    <script>
        function posSystem() {
            return {
                cart: [],
                addToCart(product) {
                    let existing = this.cart.find(i => i.id === product.id);
                    if (existing) {
                        existing.quantity++;
                    } else {
                        this.cart.push({ id: product.id, name: product.name, price: product.price, quantity: 1 });
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
                checkout() {
                    if (this.cart.length === 0) return alert('Walang laman ang cart');
                    
                    fetch('/pos/checkout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ cart: this.cart })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            this.cart = [];
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
                }
            }
        }
    </script>
</body>
</html>