<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $category->name }} - SuRasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f9f506",
                        "background-light": "#f8f8f5",
                        "background-dark": "#23220f",
                        "surface-light": "#ffffff",
                        "surface-dark": "#2c2c1f",
                        "text-main-light": "#1c1c0d",
                        "text-main-dark": "#fcfcf8",
                        "text-sec-light": "#4a4a38",
                        "text-sec-dark": "#c2c2b0",
                        "border-light": "#e9e8ce",
                        "border-dark": "#3e3e2a",
                    },
                    fontFamily: { "display": ["Spline Sans", "sans-serif"] },
                    borderRadius: {"DEFAULT": "1rem", "lg": "2rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-text-main-light dark:text-text-main-dark overflow-hidden h-screen flex">

<!-- Side Navigation -->
<aside class="w-64 h-full hidden lg:flex flex-col border-r border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark shrink-0">
    <div class="p-8 pb-4">
        <a href="{{ route('home') }}" class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold tracking-tight">SuRasa</h1>
            <p class="text-text-sec-light dark:text-text-sec-dark text-sm">Rekomendasi Kuliner</p>
        </a>
    </div>
    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
        <a class="flex items-center gap-3 px-4 py-3 rounded-full text-text-sec-light hover:bg-border-light dark:hover:bg-border-dark font-medium transition-colors" href="{{ route('home') }}">
            <span class="material-symbols-outlined">home</span>
            <span>Beranda</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-full bg-primary text-text-main-light font-semibold shadow-sm" href="{{ route('kuliners.index') }}">
            <span class="material-symbols-outlined">restaurant_menu</span>
            <span>Jelajahi</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-full text-text-sec-light hover:bg-border-light dark:hover:bg-border-dark font-medium transition-colors" href="{{ route('recipes.index') }}">
            <span class="material-symbols-outlined">menu_book</span>
            <span>Resep</span>
        </a>
        @auth
        <a class="flex items-center gap-3 px-4 py-3 rounded-full text-text-sec-light hover:bg-border-light dark:hover:bg-border-dark font-medium transition-colors" href="{{ route('recipes.my') }}">
            <span class="material-symbols-outlined">favorite</span>
            <span>Resep Saya</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-full text-text-sec-light hover:bg-border-light dark:hover:bg-border-dark font-medium transition-colors" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined">person</span>
            <span>Profil</span>
        </a>
        @endauth
    </nav>
    <div class="p-4 border-t border-border-light dark:border-border-dark">
        @auth
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-text-main-light font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-text-sec-light">Pecinta Kuliner</span>
                </div>
            </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-primary text-text-main-light font-semibold shadow-sm hover:opacity-90">
            <span class="material-symbols-outlined">login</span>
            <span>Masuk</span>
        </a>
        @endauth
    </div>
</aside>

<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden relative">
    <!-- Header -->
    <header class="flex-shrink-0 px-6 py-5 lg:px-10 flex flex-col md:flex-row md:items-center justify-between gap-4 z-10 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-sm sticky top-0">
        <div class="lg:hidden flex items-center justify-between w-full md:w-auto mb-2 md:mb-0">
            <a href="{{ route('home') }}" class="text-xl font-bold">SuRasa</a>
            <button class="p-2 rounded-full hover:bg-border-light dark:hover:bg-border-dark" id="mobileMenuBtn">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
        <!-- Search Bar -->
        <form action="{{ route('search') }}" method="GET" class="flex-1 max-w-2xl">
            <label class="flex items-center w-full h-12 bg-surface-light dark:bg-surface-dark rounded-full px-4 shadow-sm border border-transparent focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/50 transition-all">
                <span class="material-symbols-outlined text-text-sec-light">search</span>
                <input type="text" name="q" class="w-full bg-transparent border-none focus:ring-0 text-sm md:text-base px-3 placeholder-text-sec-light/50" placeholder="Cari kuliner..."/>
                <button type="submit" class="bg-primary text-black rounded-full p-1.5 hover:opacity-80 transition-opacity">
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </button>
            </label>
        </form>
        <div class="hidden md:flex items-center gap-4">
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-medium text-text-sec-light hover:text-text-main-light">Keluar</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="text-sm font-medium text-text-sec-light hover:text-text-main-light">Masuk</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-text-main-light rounded-full text-sm font-semibold hover:opacity-90">Daftar</a>
            @endauth
        </div>
    </header>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-6 lg:p-10 pb-20 scrollbar-hide">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm mb-6">
            <a href="{{ route('home') }}" class="text-text-sec-light hover:text-primary transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-text-sec-light text-[16px]">chevron_right</span>
            <a href="{{ route('kuliners.index') }}" class="text-text-sec-light hover:text-primary transition-colors">Kuliner</a>
            <span class="material-symbols-outlined text-text-sec-light text-[16px]">chevron_right</span>
            <span class="font-medium">{{ $category->name }}</span>
        </nav>

        <!-- Page Heading -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="size-16 bg-primary/20 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl text-primary">restaurant_menu</span>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight leading-tight">{{ $category->name }}</h1>
                    @if($category->description)
                    <p class="text-text-sec-light mt-1">{{ $category->description }}</p>
                    @endif
                </div>
            </div>
            <p class="text-text-sec-light">
                <strong class="text-text-main-light">{{ $kuliners->total() }}</strong> kuliner ditemukan dalam kategori ini
            </p>
        </div>

        <!-- Culinary Grid -->
        @if($kuliners->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($kuliners as $kuliner)
            <a href="{{ route('kuliners.show', $kuliner->slug) }}" class="group bg-surface-light dark:bg-surface-dark rounded-xl p-3 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="relative h-60 w-full rounded-lg overflow-hidden mb-4">
                    @if($kuliner->image)
                    <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-primary/60">restaurant</span>
                    </div>
                    @endif
                    
                    <div class="absolute top-3 right-3 {{ $kuliner->average_rating >= 4.5 ? 'bg-primary text-text-main-light' : 'bg-white dark:bg-surface-dark text-text-main-light dark:text-text-main-dark border border-border-light dark:border-border-dark' }} text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-[14px] {{ $kuliner->average_rating >= 4.5 ? '' : 'text-yellow-400' }}">star</span>
                        {{ number_format($kuliner->average_rating, 1) }}
                    </div>
                    
                    @if($kuliner->is_featured)
                    <div class="absolute top-3 left-3 bg-rose-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                        Featured
                    </div>
                    @endif
                </div>
                <div class="px-2 pb-2">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-lg leading-tight line-clamp-1">{{ $kuliner->name }}</h3>
                        <span class="text-xs font-semibold bg-border-light dark:bg-border-dark text-text-sec-light px-2 py-0.5 rounded">
                            {{ $kuliner->price_range }}
                        </span>
                    </div>
                    <p class="text-text-sec-light text-sm mb-3 line-clamp-1">{{ $kuliner->description }}</p>
                    <div class="flex items-center gap-4 text-xs font-medium text-text-sec-light">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">location_on</span>
                            {{ $kuliner->location }}
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">chat_bubble</span>
                            {{ $kuliner->total_reviews }} ulasan
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($kuliners->hasPages())
        <div class="mt-16 flex justify-center">
            <div class="flex items-center gap-2">
                @if($kuliners->onFirstPage())
                <span class="px-4 py-2 bg-border-light dark:bg-border-dark text-text-sec-light rounded-full cursor-not-allowed">
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </span>
                @else
                <a href="{{ $kuliners->previousPageUrl() }}" class="px-4 py-2 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full hover:border-primary transition-colors">
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </a>
                @endif

                <span class="px-4 py-2 text-sm font-medium text-text-sec-light">
                    Halaman {{ $kuliners->currentPage() }} dari {{ $kuliners->lastPage() }}
                </span>

                @if($kuliners->hasMorePages())
                <a href="{{ $kuliners->nextPageUrl() }}" class="px-4 py-2 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full hover:border-primary transition-colors">
                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                </a>
                @else
                <span class="px-4 py-2 bg-border-light dark:bg-border-dark text-text-sec-light rounded-full cursor-not-allowed">
                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                </span>
                @endif
            </div>
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-20">
            <div class="w-32 h-32 bg-border-light dark:bg-border-dark rounded-full flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-6xl text-text-sec-light/30">restaurant_menu</span>
            </div>
            <h3 class="text-2xl font-bold mb-2">Belum Ada Kuliner</h3>
            <p class="text-text-sec-light text-center max-w-md mb-6">
                Belum ada kuliner dalam kategori ini. Silakan cek kategori lainnya.
            </p>
            <a href="{{ route('kuliners.index') }}" class="px-6 py-3 bg-primary text-text-main-light rounded-full font-semibold hover:opacity-90 transition">
                Lihat Semua Kuliner
            </a>
        </div>
        @endif
    </div>
</main>

<!-- Mobile Menu Overlay -->
<div id="mobileMenu" class="fixed inset-0 bg-black/50 z-50 lg:hidden hidden">
    <div class="absolute left-0 top-0 h-full w-64 bg-background-light dark:bg-background-dark p-6">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-xl font-bold">SuRasa</h1>
            <button id="closeMobileMenu" class="p-2 rounded-full hover:bg-border-light">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="space-y-2">
            <a class="flex items-center gap-3 px-4 py-3 rounded-full hover:bg-border-light" href="{{ route('home') }}">
                <span class="material-symbols-outlined">home</span>Beranda
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-full bg-primary text-text-main-light font-semibold" href="{{ route('kuliners.index') }}">
                <span class="material-symbols-outlined">restaurant_menu</span>Jelajahi
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-full hover:bg-border-light" href="{{ route('recipes.index') }}">
                <span class="material-symbols-outlined">menu_book</span>Resep
            </a>
        </nav>
        @guest
        <div class="mt-8 space-y-3">
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-full border border-border-light font-medium hover:bg-border-light">Masuk</a>
            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-primary text-text-main-light font-semibold">Daftar</a>
        </div>
        @endguest
    </div>
</div>

<script>
document.getElementById('mobileMenuBtn')?.addEventListener('click', () => document.getElementById('mobileMenu').classList.remove('hidden'));
document.getElementById('closeMobileMenu')?.addEventListener('click', () => document.getElementById('mobileMenu').classList.add('hidden'));
document.getElementById('mobileMenu')?.addEventListener('click', (e) => { if(e.target === document.getElementById('mobileMenu')) document.getElementById('mobileMenu').classList.add('hidden'); });
</script>
</body>
</html>
