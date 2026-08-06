<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'FLAVOURS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F6FAF3]">
    <div class="min-h-screen flex">
        <!-- Sidebar Component -->
        @include('layouts.navigation')

        <!-- Main Content Wrapper with Left Padding for Fixed Sidebar -->
        <main class="flex-1 pl-64 w-full">
            {{ $slot }}
        </main>
    </div>
</body>
</html>