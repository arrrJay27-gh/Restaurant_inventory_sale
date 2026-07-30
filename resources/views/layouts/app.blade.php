<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts & Scripts -->
        <link rel="preconnect" href="https://bunny.net">
        <link href="https://bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- GLOBAL SIDEBAR CONTROLLER: Naka-set na 'true' para bukas ang sidebar sa simula -->
    <body x-data="{ open: true }" class="font-sans antialiased bg-slate-50 text-slate-900" style="margin: 0; padding: 0;">
        
        <div class="min-h-screen flex flex-row w-full">
            
            <!-- Kasama ang ating orihinal at collapsible sidebar navigation -->
            @include('layouts.navigation')

            <!-- DYNAMIC WORKSPACE WRAPPER: Kusa nitong binabago ang margin-left base sa lapad ng sidebar sa lahat ng screen size -->
            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300"
                 :class="open ? 'ml-64' : 'ml-20'">
                
                <!-- Main Dashboard Template Header -->
                @if (isset($header))
                    <header class="bg-white border-b border-slate-200">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Dynamic Dashboard Content Slots -->
                <main class="flex-1 w-full max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
                
            </div>

        </div>

    </body>
</html>
