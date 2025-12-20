<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - SuRasa Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Spline+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-background-light dark:bg-background-dark text-neutral-900 dark:text-neutral-100" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
            <!-- Top Bar -->
            <header class="sticky top-0 z-30 bg-surface-light/80 dark:bg-surface-dark/80 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 px-6 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-neutral-500 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                            <span class="material-symbols-outlined">menu</span>
                        </button>
                        <div>
                            <h1 class="text-xl font-bold text-neutral-900 dark:text-white leading-none">{{ $header ?? 'Dashboard' }}</h1>
                            @if(isset($description))
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 hidden sm:block">{{ $description }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Theme Toggle (Optional - assuming app has one, if not, skip) -->
                        
                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-3 pl-3 pr-2 py-1.5 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all border border-transparent hover:border-neutral-200 dark:hover:border-neutral-700">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-bold text-neutral-900 dark:text-white leading-none">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-neutral-500 font-medium uppercase tracking-wider mt-0.5">Administrator</p>
                                </div>
                                @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="size-9 rounded-full object-cover border border-neutral-200 dark:border-neutral-700">
                                @else
                                <div class="size-9 rounded-full bg-primary/20 flex items-center justify-center text-primary-dark font-bold text-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                @endif
                                <span class="material-symbols-outlined text-neutral-400 text-[20px]" :class="open ? 'rotate-180' : ''">expand_more</span>
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute right-0 mt-2 w-56 bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl border border-neutral-100 dark:border-neutral-800 py-1.5 z-50 origin-top-right">
                                
                                <div class="px-4 py-3 border-b border-neutral-100 dark:border-neutral-800 sm:hidden">
                                    <p class="text-sm font-bold text-neutral-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-neutral-500">Administrator</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">person</span>
                                    Edit Profil
                                </a>
                                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">public</span>
                                    Lihat Website
                                </a>
                                
                                <div class="h-px bg-neutral-100 dark:bg-neutral-800 my-1.5 mx-2"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">logout</span>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-8 overflow-x-hidden">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            // Icon selection
            let icon = 'check_circle';
            let colorClass = 'bg-surface-light dark:bg-neutral-800 border-l-4 border-green-500 text-neutral-900 dark:text-white';
            
            if (type === 'error') {
                icon = 'error';
                colorClass = 'bg-surface-light dark:bg-neutral-800 border-l-4 border-red-500 text-neutral-900 dark:text-white';
            }

            toast.className = `flex items-center gap-3 min-w-[300px] p-4 rounded-lg shadow-xl border border-neutral-100 dark:border-neutral-700 pointer-events-auto transform translate-y-10 opacity-0 transition-all duration-300 ${colorClass}`;
            
            toast.innerHTML = `
                <span class="material-symbols-outlined ${type === 'success' ? 'text-green-500' : 'text-red-500'}">${icon}</span>
                <p class="text-sm font-bold">${message}</p>
                <button onclick="this.parentElement.remove()" class="ml-auto text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            `;
            
            container.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            });
            
            // Auto dismiss
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // Check for session flash messages
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>
