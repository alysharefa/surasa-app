<header x-data="{ open: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300"
        :class="{ 'bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 transition-all duration-300" :class="{ 'h-16': scrolled }">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="size-10 relative overflow-hidden rounded-xl transition-transform duration-300 group-hover:rotate-6">
                    <img src="{{ asset('images/logo.png') }}" alt="SuRasa Logo" class="w-full h-full object-contain transform transition-transform duration-300 group-hover:scale-110">
                    <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-2xl font-black text-text-main-light dark:text-text-main-dark tracking-tight">SuRasa<span class="text-primary">.</span></span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center p-1.5 rounded-full bg-surface-light/50 dark:bg-surface-dark/50 border border-border-light/50 dark:border-border-dark/50 backdrop-blur-sm shadow-sm">
                @php
                    $navLinks = [
                        ['route' => 'home', 'label' => 'Beranda', 'icon' => 'home'],
                        ['route' => 'kuliners.index', 'label' => 'Jelajah Kuliner', 'icon' => 'explore'],
                        ['route' => 'recipes.index', 'label' => 'Resep Komunitas', 'icon' => 'menu_book'],
                    ];
                @endphp

                @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}" 
                   class="relative px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 flex items-center gap-2
                   {{ request()->routeIs($link['route'].'*') ? 'text-primary-dark bg-white dark:bg-black/20 shadow-sm' : 'text-text-sec-light dark:text-text-sec-dark hover:text-text-main-light dark:hover:text-text-main-dark hover:bg-white/50 dark:hover:bg-white/5' }}">
                    <span class="material-symbols-outlined text-[18px] {{ request()->routeIs($link['route'].'*') ? 'fill-current' : '' }}">{{ $link['icon'] }}</span>
                    {{ $link['label'] }}
                </a>
                @endforeach
            </nav>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-4">
                @auth
                <a href="{{ route('recipes.create') }}" class="hidden sm:flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-yellow-400 text-text-main-light rounded-full text-sm font-bold hover:shadow-lg hover:shadow-primary/20 hover:scale-105 transition-all duration-300">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    Tulis Resep
                </a>
                
                <!-- User Dropdown -->
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-3 cursor-pointer focus:outline-none group">
                        @if(auth()->user()->avatar)
                            <div class="size-10 rounded-full border-2 border-primary overflow-hidden shadow-md group-hover:ring-4 group-hover:ring-primary/20 transition-all">
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="size-10 bg-surface-light dark:bg-surface-dark border-2 border-primary rounded-full flex items-center justify-center text-primary-dark font-black shadow-md group-hover:ring-4 group-hover:ring-primary/20 transition-all">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </button>

                    <div x-show="dropdownOpen" 
                         @click.away="dropdownOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-64 bg-surface-light dark:bg-surface-dark rounded-2xl shadow-xl border border-border-light dark:border-border-dark py-2 z-50 transform origin-top-right overflow-hidden">
                        
                        <div class="px-4 py-4 border-b border-border-light dark:border-border-dark bg-background-light/50 dark:bg-background-dark/50 flex items-center gap-3">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="size-10 rounded-full object-cover">
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-text-main-light dark:text-text-main-dark truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-text-sec-light dark:text-text-sec-dark truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        
                        <div class="p-2 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-text-main-light dark:text-text-main-dark hover:bg-primary/10 hover:text-primary-dark rounded-xl transition-colors">
                                <span class="material-symbols-outlined text-[20px]">person</span>
                                Edit Profil
                            </a>
                            <a href="{{ route('recipes.my') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-text-main-light dark:text-text-main-dark hover:bg-primary/10 hover:text-primary-dark rounded-xl transition-colors">
                                <span class="material-symbols-outlined text-[20px]">menu_book</span>
                                Resep Saya
                                <span class="ml-auto text-xs bg-primary/20 text-primary-dark px-2 py-0.5 rounded-full font-bold">{{ auth()->user()->recipes()->count() }}</span>
                            </a>
                            <a href="{{ route('bookmarks.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-text-main-light dark:text-text-main-dark hover:bg-primary/10 hover:text-primary-dark rounded-xl transition-colors">
                                <span class="material-symbols-outlined text-[20px]">bookmark</span>
                                Resep Disimpan
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <div class="h-px bg-border-light dark:border-border-dark my-1"></div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-text-main-light dark:text-text-main-dark hover:bg-primary/10 hover:text-primary-dark rounded-xl transition-colors">
                                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                                Dashboard Admin
                            </a>
                            @endif
                        </div>

                        <div class="border-t border-border-light dark:border-border-dark p-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-3 py-2 text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-xl transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @else
                <div class="flex items-center bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full p-1 shadow-sm">
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-sm font-bold text-text-main-light dark:text-text-main-dark hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-primary text-text-main-light rounded-full text-sm font-bold hover:shadow-lg hover:shadow-primary/20 transition-all">
                        Daftar
                    </a>
                </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="open = true" class="md:hidden p-2 text-text-main-light dark:text-text-main-dark hover:bg-surface-light dark:hover:bg-surface-dark rounded-full transition-colors">
                    <span class="material-symbols-outlined text-[28px]">menu</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="open" 
         style="display: none;"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="absolute right-0 top-0 h-full w-80 bg-surface-light dark:bg-surface-dark p-6 shadow-2xl border-l border-border-light dark:border-border-dark"
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            
            <div class="flex items-center justify-between mb-8">
                <span class="text-2xl font-black text-text-main-light dark:text-text-main-dark">Menu</span>
                <button @click="open = false" class="p-2 rounded-full hover:bg-background-light dark:hover:bg-background-dark text-text-main-light dark:text-text-main-dark transition-colors">
                    <span class="material-symbols-outlined text-[24px]">close</span>
                </button>
            </div>

            <nav class="flex flex-col gap-2">
                @foreach($navLinks as $link)
                <a class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all
                    {{ request()->routeIs($link['route'].'*') ? 'bg-primary text-text-main-light shadow-lg shadow-primary/20' : 'hover:bg-background-light dark:hover:bg-background-dark text-text-sec-light dark:text-text-sec-dark hover:text-text-main-light dark:hover:text-text-main-dark' }}" 
                    href="{{ route($link['route']) }}">
                    <span class="material-symbols-outlined {{ request()->routeIs($link['route'].'*') ? 'fill-current' : '' }}">{{ $link['icon'] }}</span>
                    {{ $link['label'] }}
                </a>
                @endforeach
                
                <div class="h-px bg-border-light dark:bg-border-dark my-4"></div>
                
                @auth
                <a class="flex items-center gap-4 px-4 py-3.5 rounded-2xl hover:bg-background-light dark:hover:bg-background-dark transition-colors text-text-main-light dark:text-text-main-dark font-medium" href="{{ route('recipes.create') }}">
                    <span class="material-symbols-outlined text-primary">add_circle</span>
                    Tulis Resep
                </a>
                <a class="flex items-center gap-4 px-4 py-3.5 rounded-2xl hover:bg-background-light dark:hover:bg-background-dark transition-colors text-text-main-light dark:text-text-main-dark font-medium" href="{{ route('recipes.my') }}">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                    Resep Saya
                </a>
                <a class="flex items-center gap-4 px-4 py-3.5 rounded-2xl hover:bg-background-light dark:hover:bg-background-dark transition-colors text-text-main-light dark:text-text-main-dark font-medium" href="{{ route('profile.edit') }}">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Profil saya
                </a>
                <div class="mt-4 pt-4 border-t border-border-light dark:border-border-dark">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-4 px-4 py-3.5 rounded-2xl hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-red-500 font-bold">
                            <span class="material-symbols-outlined">logout</span>
                            Keluar
                        </button>
                    </form>
                </div>
                @endauth

                @guest
                <div class="mt-auto space-y-3 pt-6">
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-3.5 rounded-2xl border border-border-light dark:border-border-dark font-bold hover:bg-background-light dark:hover:bg-background-dark transition-colors text-text-main-light dark:text-text-main-dark w-full">
                        Masuk Akun
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-3.5 rounded-2xl bg-primary text-text-main-light font-bold hover:shadow-lg hover:shadow-primary/20 transition-all w-full">
                        Daftar Sekarang
                    </a>
                </div>
                @endguest
            </nav>
        </div>
    </div>
</header>
