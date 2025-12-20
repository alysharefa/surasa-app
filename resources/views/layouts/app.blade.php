<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Spline+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-display antialiased text-text-main-light dark:text-text-main-dark bg-background-light dark:bg-background-dark">
        <div class="min-h-screen flex flex-col">
            <x-navbar />

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-surface-light dark:bg-surface-dark shadow-sm border-b border-border-light dark:border-border-dark sticky top-16 z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow animate-page-load {{ request()->routeIs('home') ? '' : 'pt-20' }}">
                {{ $slot }}
            </main>

            <x-footer />
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 z-50 w-full h-20 bg-surface-light/90 dark:bg-surface-dark/90 backdrop-blur-lg border-t border-border-light dark:border-border-dark md:hidden pb-safe">
            <div class="grid grid-cols-5 h-full max-w-lg mx-auto">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-white/5 group {{ request()->routeIs('home') ? 'text-primary' : 'text-text-sec-light dark:text-text-sec-dark' }}">
                    <span class="material-symbols-outlined text-2xl mb-1 group-hover:scale-110 transition-transform {{ request()->routeIs('home') ? 'fill' : '' }}">home</span>
                    <span class="text-[10px] font-medium">Beranda</span>
                </a>
                <a href="{{ route('kuliners.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-white/5 group {{ request()->routeIs('kuliners.*') ? 'text-primary' : 'text-text-sec-light dark:text-text-sec-dark' }}">
                    <span class="material-symbols-outlined text-2xl mb-1 group-hover:scale-110 transition-transform {{ request()->routeIs('kuliners.*') ? 'fill' : '' }}">explore</span>
                    <span class="text-[10px] font-medium">Jelajah</span>
                </a>
                <div class="flex items-center justify-center relative">
                    <a href="{{ route('recipes.create') }}" class="absolute -top-6 inline-flex items-center justify-center w-14 h-14 font-medium bg-primary rounded-full shadow-lg shadow-primary/30 hover:scale-110 transition-transform text-black">
                        <span class="material-symbols-outlined text-3xl">add</span>
                    </a>
                </div>
                <a href="{{ route('recipes.index') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-white/5 group {{ request()->routeIs('recipes.*') && !request()->routeIs('recipes.create') ? 'text-primary' : 'text-text-sec-light dark:text-text-sec-dark' }}">
                    <span class="material-symbols-outlined text-2xl mb-1 group-hover:scale-110 transition-transform {{ request()->routeIs('recipes.*') ? 'fill' : '' }}">menu_book</span>
                    <span class="text-[10px] font-medium">Resep</span>
                </a>
                <a href="{{ auth()->check() ? route('recipes.my') : route('login') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-white/5 group {{ request()->routeIs('profile.*') || request()->routeIs('recipes.my') || request()->routeIs('bookmarks.index') ? 'text-primary' : 'text-text-sec-light dark:text-text-sec-dark' }}">
                    @auth
                        @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="size-6 rounded-full object-cover mb-1 border border-transparent group-hover:border-primary transition-colors {{ request()->routeIs('profile.*') || request()->routeIs('recipes.my') || request()->routeIs('bookmarks.index') ? 'border-primary' : '' }}">
                        @else
                        <div class="size-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold mb-1 border border-transparent group-hover:border-primary transition-colors {{ request()->routeIs('profile.*') || request()->routeIs('recipes.my') || request()->routeIs('bookmarks.index') ? 'border-primary bg-primary text-white' : '' }}">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        @endif
                    @else
                    <span class="material-symbols-outlined text-2xl mb-1 group-hover:scale-110 transition-transform">person</span>
                    @endauth
                    <span class="text-[10px] font-medium">{{ auth()->check() ? 'Akun' : 'Masuk' }}</span>
                </a>
            </div>
        </div>
    </body>
</html>
