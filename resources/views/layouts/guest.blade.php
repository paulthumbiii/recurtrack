<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RecurTrack') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-300 antialiased bg-slate-900 selection:bg-indigo-500 selection:text-white">
    
    <!-- Background Ambient Glow -->
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-tr from-indigo-600/10 via-purple-600/10 to-violet-600/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        
        <!-- Logo -->
        <div class="mb-8 z-10">
            <a href="/" class="text-3xl font-extrabold text-white tracking-tight">
                Recur<span class="text-indigo-400">Track</span>
            </a>
        </div>

        <!-- Glowing Card Wrapper -->
        <div class="relative w-full sm:max-w-md mx-auto z-10 group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
            
            <div class="relative bg-slate-900 border border-slate-800 shadow-2xl overflow-hidden rounded-xl p-8">
                {{ $slot }}
            </div>
        </div>
        
    </div>
</body>
</html>