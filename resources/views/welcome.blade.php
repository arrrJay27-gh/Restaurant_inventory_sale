<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavours - Restaurant</title>
    <style>
        /* Base Reset & Core Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f2ffe9;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Navigation Layout */
        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 50;
        }
        .logo-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        /* Logo Graphic Shape Match */
        .logo-box {
            background-color: #5ce625;
            width: 42px;
            height: 34px;
            border-radius: 12px 12px 4px 12px;
        }
        .logo-text {
            font-weight: bold;
            font-size: 22px;
            letter-spacing: 0.5px;
            color: #1f2937;
            text-transform: uppercase;
        }
        .nav-links {
            display: flex;
            gap: 36px;
        }
        .nav-links a {
            text-decoration: none;
            color: #6b7280;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.2s;
        }
        .nav-links a.active {
            color: #49c21a;
            position: relative;
            font-weight: bold;
        }
        /* Curved line beneath active home item */
        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #5ce625;
            border-radius: 2px;
        }
        .nav-links a:hover {
            color: #49c21a;
        }
        .btn-contact {
            background-color: #5ce625;
            color: #111827;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-contact:hover {
            background-color: #49c21a;
        }

        /* Hero Main Viewframe Section */
        .hero-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 80px 20px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
            gap: 40px;
            position: relative;
            z-index: 10;
        }
        .hero-left {
            max-width: 580px;
        }
        .hero-right {
            display: flex;
            justify-content: flex-end;
            position: relative;
            height: 100%;
            align-items: center;
        }
        
        /* Layout Typography Styling */
        .title-light {
            font-size: 64px;
            font-weight: 300;
            color: #111827;
            margin-bottom: 8px;
            line-height: 1.1;
        }
        .title-bold {
            font-size: 56px;
            font-weight: bold;
            color: #49c21a;
            margin-bottom: 20px;
            line-height: 1.15;
        }
        .sub-text {
            font-size: 26px;
            color: #374151;
            margin-bottom: 40px;
            font-weight: 500;
        }
        .sub-text span {
            font-weight: bold;
            color: #2d7a10;
        }
        .btn-order {
            display: inline-block;
            background-color: #5ce625;
            color: #111827;
            text-decoration: none;
            font-weight: bold;
            padding: 16px 44px;
            border-radius: 50px;
            font-size: 18px;
            box-shadow: 0 8px 20px rgba(92, 230, 37, 0.3);
            transition: transform 0.2s, background 0.2s;
        }
        .btn-order:hover {
            background-color: #49c21a;
            transform: translateY(-2px);
        }

        /* Fluid Corner Framing Graphics */
        .green-shape {
            position: absolute;
            right: -120px;
            top: -20px;
            width: 620px;
            height: 580px;
            background-color: #39c611;
            border-top-left-radius: 180px;
            border-bottom-right-radius: 40px;
            transform: rotate(4deg);
            z-index: -1;
        }
        
        /* Centered Floating Image Card Frame */
        .image-card {
            background-color: white;
            padding: 14px;
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.18);
            width: 380px;
            position: relative;
            right: 40px;
            transform: rotate(-2deg);
        }
        .image-card img {
            width: 100%;
            height: 460px;
            object-fit: cover; /* Fixed: Corrected standard CSS property from object-cover */
            border-radius: 20px;
            display: block;
        }

        /* Dynamic Solid Structural Edge Vector Accent Curve */
        .bottom-right-curve {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 450px;
            height: 450px;
            background-color: #39c611;
            border-top-left-radius: 100%;
            z-index: -2;
        }

        /* Mobile Breakpoint Layout Responsiveness */
        @media (max-width: 992px) {
            .hero-section {
                grid-template-columns: 1fr;
                text-align: center;
                padding-top: 20px;
                gap: 60px;
            }
            .hero-left {
                margin: 0 auto;
            }
            .hero-right {
                justify-content: center;
                margin-bottom: 60px;
            }
            .green-shape {
                display: none;
            }
            .image-card {
                right: 0;
                transform: none;
                width: 100%;
                max-width: 360px;
            }
            .image-card img {
                height: 400px;
            }
            .nav-links, .btn-contact {
                display: none;
            }
            .title-light { font-size: 46px; }
            .title-bold { font-size: 42px; }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar Header -->
    <header class="navbar">
        <div class="logo-group">
            <div class="logo-box"></div>
            <span class="logo-text">Flavours</span>
        </div>
        <nav class="nav-links">
            <a href="#" class="active">Home</a>
            <a href="#">About Us</a>
            <a href="#">Products</a>
            <a href="#">Contact Us</a>
        </nav>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-contact">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-contact">Login</a>
                @endauth
            @endif
        </div>
    </header>

    <!-- Main View Section Layout -->
    <main class="hero-section">
        <!-- Left Side Context Area -->
        <div class="hero-left">
            <h1 class="title-light">Are you Hungry?</h1>
            <h2 class="title-bold">What are you waiting<br>for?</h2>
            <p class="sub-text">taste our best <span>Flavours</span></p>
            
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-order">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-order">Order Now</a>
            @endauth
        </div>

        <!-- Right Side Media Banner Area -->
        <div class="hero-right">
            <div class="green-shape"></div>
            <div class="image-card">
                <!-- Points to your local image in the public folder -->
                <img src="{{ asset('salad.webp') }}" alt="Fresh Healthy Salad Bowl Selection">
            </div>
        </div>
    </main>

    <!-- Solid Edge Base Layer Background Vector Shape Accent -->
    <div class="bottom-right-curve"></div>

</body>
</html>
