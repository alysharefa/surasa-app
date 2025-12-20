<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - SuRasa Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark text-neutral-900 dark:text-white font-display overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen w-full">
        <!-- Side Navigation -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <main class="flex-1 h-full flex flex-col overflow-hidden bg-background-light dark:bg-background-dark relative">
            
            <!-- Top Navbar -->
            @include('components.admin-navbar')

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="max-w-[1200px] mx-auto p-6 md:p-8 flex flex-col gap-8">
                    <!-- Breadcrumbs -->
                    @if(isset($breadcrumbs))
                    <nav class="flex items-center gap-2 text-sm animate-fade-in-up">
                        <a class="text-neutral-500 hover:text-primary transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @foreach($breadcrumbs as $crumb)
                        <span class="text-neutral-400 material-symbols-outlined text-[16px]">chevron_right</span>
                        @if(isset($crumb['url']))
                        <a class="text-neutral-500 hover:text-primary transition-colors" href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                        @else
                        <span class="text-neutral-900 dark:text-white font-medium">{{ $crumb['label'] }}</span>
                        @endif
                        @endforeach
                    </nav>
                    @endif

                    <!-- Page Header -->
                    @if(isset($header))
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate-fade-in-up delay-100">
                        <div class="flex flex-col gap-2">
                            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white tracking-tight">{{ $header }}</h1>
                            @if(isset($description))
                            <p class="text-neutral-500 dark:text-neutral-400 text-base max-w-2xl">{{ $description }}</p>
                            @endif
                        </div>
                        @if(isset($actions))
                        <div class="flex gap-3">
                            {{ $actions }}
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div id="success-alert" class="p-4 bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 border-2 border-green-400 dark:border-green-600 text-green-800 dark:text-green-300 rounded-xl flex items-center justify-between gap-3 shadow-lg animate-fade-in-up delay-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center shadow-md">
                                <span class="material-symbols-outlined text-white text-[20px]">check_circle</span>
                            </div>
                            <div>
                                <p class="font-bold text-green-900 dark:text-green-200">Berhasil!</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button onclick="document.getElementById('success-alert').remove()" class="p-1 hover:bg-green-200 dark:hover:bg-green-800 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div id="error-alert" class="p-4 bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 border-2 border-red-400 dark:border-red-600 text-red-800 dark:text-red-300 rounded-xl flex items-center justify-between gap-3 shadow-lg animate-fade-in-up delay-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center shadow-md">
                                <span class="material-symbols-outlined text-white text-[20px]">error</span>
                            </div>
                            <div>
                                <p class="font-bold text-red-900 dark:text-red-200">Error!</p>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button onclick="document.getElementById('error-alert').remove()" class="p-1 hover:bg-red-200 dark:hover:bg-red-800 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div id="validation-alert" class="p-4 bg-gradient-to-r from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30 border-2 border-yellow-400 dark:border-yellow-600 text-yellow-800 dark:text-yellow-300 rounded-xl shadow-lg animate-fade-in-up delay-100">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center shadow-md">
                                <span class="material-symbols-outlined text-white text-[20px]">warning</span>
                            </div>
                            <div>
                                <p class="font-bold text-yellow-900 dark:text-yellow-200">Validasi Gagal!</p>
                                <p class="text-sm">Mohon perbaiki kesalahan berikut:</p>
                            </div>
                        </div>
                        <ul class="list-disc list-inside space-y-1 ml-13 text-sm">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @push('styles')
                    <style>
                    /* Removed inline styles in favor of app.css classes */
                    </style>
                    @endpush

                    @push('scripts')
                    <script>
                    // Auto dismiss alerts after 5 seconds (Updated for fade-in-up)
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            const successAlert = document.getElementById('success-alert');
                            if (successAlert) {
                                successAlert.style.transition = 'opacity 0.5s, transform 0.5s';
                                successAlert.style.opacity = '0';
                                successAlert.style.transform = 'translateY(-20px)';
                                setTimeout(() => successAlert.remove(), 500);
                            }
                        }, 5000);
                    });
                    </script>
                    @endpush

                    <!-- Page Content (Staggered) -->
                    <div class="animate-fade-in-up delay-200">
                        {{ $slot }}
                    </div>

                    <!-- Spacer for scrolling -->
                    <div class="h-10"></div>
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
