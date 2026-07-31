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
    <body x-data="{ open: true }" class="font-sans antialiased bg-slate-50 text-slate-900" style="margin: 0; padding: 0;">
        
       
        <div class="min-h-screen flex flex-row w-full items-start overflow-x-hidden">
            
            
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto transition-all duration-300">
                
                @if (isset($header))
                    <header class="bg-white border-b border-slate-200 flex-shrink-0">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1 w-full max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
                
            </div>

        </div>

    </body>
</html>
