<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavours - Restaurant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#f2fbe8] text-slate-800 font-sans antialiased" 
      x-data="{ 
          profileDropdownOpen: false, 
          loginModalOpen: {{ $errors->any() ? 'true' : 'false' }}, 
          isRegister: false 
      }">

    <!-- Navbar -->
    <nav class="sticky top-0 z-40 bg-[#f2fbe8]/90 backdrop-blur-md px-8 py-4 flex justify-between items-center max-w-7xl mx-auto">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-lime-500 rounded-lg"></div>
            <span class="text-2xl font-black tracking-wider text-slate-900">FLAVOURS</span>
        </div>

        <!-- Navigation Links -->
        <div class="hidden md:flex space-x-8 font-semibold text-slate-600">
            <a href="#home" class="hover:text-lime-600 transition">Home</a>
            <a href="#about" class="hover:text-lime-600 transition">About Us</a>
            <a href="#products" class="hover:text-lime-600 transition">Products</a>
            <a href="#contact" class="hover:text-lime-600 transition">Contact Us</a>
        </div>

        <!-- Profile / Sign-In Dropdown -->
        <div class="relative">
            <button @click="profileDropdownOpen = !profileDropdownOpen" 
                    @click.away="profileDropdownOpen = false"
                    class="flex items-center space-x-2 bg-white border border-slate-200 px-4 py-2.5 rounded-full shadow-sm hover:border-lime-300 hover:shadow-md transition">
                
                <!-- Profile Icon -->
                <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                
                <span class="font-bold text-slate-700 text-sm">
                    @auth
                        {{ Auth::user()->name }}
                    @else
                        Sign In
                    @endauth
                </span>
                
                <!-- Down Arrow -->
                <svg class="w-4 h-4 text-slate-400 transition-transform" :class="{'rotate-180': profileDropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="profileDropdownOpen"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-3 z-50"
                 style="display: none;">
                
                @auth
                    <!-- Dashboard Link para sa Admin / Staff -->
                    @if(in_array(strtolower(str_replace([' ', '_'], '', Auth::user()->role ?? '')), ['admin', 'staff', 'manager', 'inventorymanager']))
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-slate-100 transition text-slate-700">
                            <div class="p-2 bg-slate-100 rounded-lg text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="font-semibold block text-sm">Dashboard</span>
                                <span class="text-xs text-slate-500">Admin Control Panel</span>
                            </div>
                        </a>
                    @else
                        <!-- Link sa POS para sa Naka-login na Customer -->
                        <a href="/pos" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-lime-50 transition text-slate-700 hover:text-lime-700">
                            <div class="p-2 bg-lime-100 rounded-lg text-lime-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="font-semibold block text-sm">Order Menu (POS)</span>
                                <span class="text-xs text-slate-500">Go to Ordering Screen</span>
                            </div>
                        </a>
                    @endif

                    <!-- OPTION B: Dynamic Logout Form -->
                    <div class="border-t border-slate-100 mt-1 pt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center space-x-3 px-4 py-2.5 hover:bg-red-50 transition text-red-600">
                                <div class="p-2 bg-red-100 rounded-lg text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-semibold block text-sm">Log Out</span>
                                    <span class="text-xs text-red-400">Exit active session</span>
                                </div>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="px-4 pb-2 mb-2 border-b border-slate-100">
                        <p class="text-xs text-slate-400 font-medium">Welcome to Flavours</p>
                        <p class="text-sm font-bold text-slate-800">Please Sign In As:</p>
                    </div>

                    <!-- Customer Login Button -->
                    <button @click="loginModalOpen = true; profileDropdownOpen = false; isRegister = false;" class="w-full text-left flex items-center space-x-3 px-4 py-2.5 hover:bg-lime-50 transition text-slate-700 hover:text-lime-700">
                        <div class="p-2 bg-lime-100 rounded-lg text-lime-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="font-semibold block text-sm">Customer</span>
                            <span class="text-xs text-slate-500">To Order Online</span>
                        </div>
                    </button>

                    <!-- Admin / Staff Login Button -->
                    <button @click="loginModalOpen = true; profileDropdownOpen = false; isRegister = false;" class="w-full text-left flex items-center space-x-3 px-4 py-2.5 hover:bg-slate-100 transition text-slate-700 hover:text-slate-900">
                        <div class="p-2 bg-slate-100 rounded-lg text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="font-semibold block text-sm">Admin / Staff</span>
                            <span class="text-xs text-slate-500">Access Dashboard</span>
                        </div>
                    </button>
                @endauth

            </div>
        </div>
    </nav>

    <!-- CUSTOMER & ADMIN LOGIN / REGISTER MODAL -->
    <div x-show="loginModalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div @click.away="loginModalOpen = false" 
             class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100">
            
            <!-- Close Button -->
            <button @click="loginModalOpen = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Global Error Display -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-xs font-semibold">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- LOGIN FORM -->
            <div x-show="!isRegister">
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-lime-100 text-lime-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900">Sign In</h3>
                    <p class="text-slate-500 text-sm mt-1">Enter your credentials to access your account</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your-email@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:border-lime-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password</label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:border-lime-500">
                    </div>
                    <button type="submit" class="w-full bg-lime-500 hover:bg-lime-600 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-lime-500/30">
                        Sign In
                    </button>
                </form>

                <div class="text-center mt-6 text-sm text-slate-500">
                    Don't have an account? 
                    <button @click="isRegister = true" class="text-lime-600 font-bold hover:underline">Create Account</button>
                </div>
            </div>

            <!-- REGISTER FORM -->
            <div x-show="isRegister">
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-lime-100 text-lime-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900">Create Account</h3>
                    <p class="text-slate-500 text-sm mt-1">Register to order your favorite dishes</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Juan Dela Cruz" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:border-lime-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="customer@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:border-lime-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password</label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:border-lime-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:border-lime-500">
                    </div>
                    <button type="submit" class="w-full bg-lime-500 hover:bg-lime-600 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-lime-500/30">
                        Create Account
                    </button>
                </form>

                <div class="text-center mt-6 text-sm text-slate-500">
                    Already have an account? 
                    <button @click="isRegister = false" class="text-lime-600 font-bold hover:underline">Sign In</button>
                </div>
            </div>

        </div>
    </div>

    <!-- 1. HOME SECTION -->
    <section id="home" class="max-w-7xl mx-auto px-8 py-16 grid md:grid-cols-2 gap-12 items-center min-h-[85vh]">
        <div class="space-y-6">
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 leading-tight">
                Are you Hungry?<br>
                <span class="text-lime-500">What are you waiting for?</span>
            </h1>
            <p class="text-xl text-slate-600 font-medium">
                Taste our best <span class="text-lime-600 font-bold">Flavours</span>
            </p>
            <div>
                <a href="#products" class="inline-block bg-lime-500 hover:bg-lime-600 text-white font-bold px-8 py-4 rounded-full shadow-xl shadow-lime-500/30 transition hover:-translate-y-0.5">
                    Explore Our Menu
                </a>
            </div>
        </div>
        <div class="relative flex justify-center">
            <div class="absolute -z-10 bg-lime-500 w-72 h-72 md:w-96 md:h-96 rounded-3xl rotate-6 top-4"></div>
            <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=800&q=80" 
                 alt="Flavours Special Dish" 
                 class="w-80 md:w-96 h-96 md:h-[28rem] object-cover rounded-2xl shadow-2xl border-4 border-white">
        </div>
    </section>

    <!-- 2. ABOUT US SECTION -->
    <section id="about" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-8 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80" 
                     alt="Our Restaurant" 
                     class="rounded-3xl shadow-xl border-4 border-lime-100">
            </div>
            <div class="space-y-4">
                <span class="text-lime-600 font-bold uppercase tracking-wider text-sm">About Us</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Crafting Unforgettable Culinary Experiences</h2>
                <p class="text-slate-600 leading-relaxed">
                    At Flavours, we believe that food is more than just nourishment—it’s an experience. Established with a passion for fresh ingredients and bold taste profiles, our kitchen prepares every meal with utmost care and authenticity.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="p-4 bg-lime-50 rounded-2xl border border-lime-100">
                        <h3 class="text-2xl font-black text-lime-600">100%</h3>
                        <p class="text-xs text-slate-600 font-semibold mt-1">Fresh Ingredients</p>
                    </div>
                    <div class="p-4 bg-lime-50 rounded-2xl border border-lime-100">
                        <h3 class="text-2xl font-black text-lime-600">5★</h3>
                        <p class="text-xs text-slate-600 font-semibold mt-1">Customer Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. PRODUCTS SECTION -->
    <section id="products" class="max-w-7xl mx-auto px-8 py-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-lime-600 font-bold uppercase tracking-wider text-sm">Our Menu</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-1">Popular Products</h2>
            <p class="text-slate-600 mt-2">Explore our crowd favorites crafted with rich flavors and fresh produce.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Product 1 -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=500&q=80" alt="Special Burger" class="w-full h-48 object-cover rounded-2xl mb-4">
                <h3 class="text-xl font-bold text-slate-800">Classic Beef Burger</h3>
                <p class="text-slate-500 text-sm mt-1">Juicy beef patty with fresh lettuce and house sauce.</p>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-lime-600 font-black text-xl">₱99.00</span>
                    @auth
                        <a href="/pos" class="bg-slate-900 hover:bg-lime-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition inline-block">Order Now</a>
                    @else
                        <button @click="loginModalOpen = true; isRegister = false" class="bg-slate-900 hover:bg-lime-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition">Order Now</button>
                    @endauth
                </div>
            </div>

            <!-- Product 2 -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=500&q=80" alt="Pasta" class="w-full h-48 object-cover rounded-2xl mb-4">
                <h3 class="text-xl font-bold text-slate-800">Savory Spaghetti</h3>
                <p class="text-slate-500 text-sm mt-1">Rich tomato sauce topped with herbs and cheese.</p>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-lime-600 font-black text-xl">₱89.00</span>
                    @auth
                        <a href="/pos" class="bg-slate-900 hover:bg-lime-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition inline-block">Order Now</a>
                    @else
                        <button @click="loginModalOpen = true; isRegister = false" class="bg-slate-900 hover:bg-lime-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition">Order Now</button>
                    @endauth
                </div>
            </div>

            <!-- Product 3 -->
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?auto=format&fit=crop&w=500&q=80" alt="Fried Chicken" class="w-full h-48 object-cover rounded-2xl mb-4">
                <h3 class="text-xl font-bold text-slate-800">Crispy Fried Chicken</h3>
                <p class="text-slate-500 text-sm mt-1">Golden crispy chicken served with gravy.</p>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-lime-600 font-black text-xl">₱120.00</span>
                    @auth
                        <a href="/pos" class="bg-slate-900 hover:bg-lime-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition inline-block">Order Now</a>
                    @else
                        <button @click="loginModalOpen = true; isRegister = false" class="bg-slate-900 hover:bg-lime-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition">Order Now</button>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- 4. CONTACT US SECTION -->
    <section id="contact" class="bg-slate-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-8 grid md:grid-cols-2 gap-12">
            <div>
                <span class="text-lime-400 font-bold uppercase tracking-wider text-sm">Get in Touch</span>
                <h2 class="text-3xl md:text-4xl font-extrabold mt-1">Contact Us</h2>
                <p class="text-slate-400 mt-3">Have questions or want to make a reservation? Send us a message!</p>
                
                <div class="space-y-4 mt-8">
                    <div class="flex items-center space-x-3 text-slate-300">
                        <span class="font-bold text-lime-400">Location:</span>
                        <span>Main Street, Restaurant Avenue, City</span>
                    </div>
                    <div class="flex items-center space-x-3 text-slate-300">
                        <span class="font-bold text-lime-400">Phone:</span>
                        <span>+63 912 345 6789</span>
                    </div>
                    <div class="flex items-center space-x-3 text-slate-300">
                        <span class="font-bold text-lime-400">Email:</span>
                        <span>info@flavoursrestaurant.com</span>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <form class="bg-slate-800 p-8 rounded-3xl space-y-4 border border-slate-700">
                <div>
                    <label class="block text-sm font-semibold mb-1">Your Name</label>
                    <input type="text" placeholder="John Doe" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-lime-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Email Address</label>
                    <input type="email" placeholder="john@example.com" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-lime-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Message</label>
                    <textarea rows="3" placeholder="How can we help you?" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-lime-500"></textarea>
                </div>
                <button type="button" class="w-full bg-lime-500 hover:bg-lime-600 text-white font-bold py-3 rounded-xl transition">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-500 py-6 text-center text-sm">
        &copy; 2026 Flavours Restaurant. All rights reserved.
    </footer>

</body>
</html>