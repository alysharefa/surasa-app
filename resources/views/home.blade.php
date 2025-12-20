<x-app-layout>
    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
    </style>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-background-light via-primary/5 to-primary/10 dark:from-background-dark dark:via-primary/5 dark:to-primary/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16 lg:pt-20 lg:pb-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left animate-fade-in-up">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight mb-6">
                        Temukan <span class="text-primary-dark">Cita Rasa</span> Terbaik Indonesia
                    </h1>
                    <p class="text-lg text-text-sec-light dark:text-text-sec-dark mb-8 max-w-xl mx-auto lg:mx-0 delay-100 animate-fade-in-up" style="animation-fill-mode: both;">
                        Jelajahi ribuan kuliner dan resep autentik dari seluruh Nusantara. Bagikan pengalaman kulinermu bersama komunitas pecinta makanan.
                    </p>

                    <!-- Search Bar -->
                    <form action="{{ route('search') }}" method="GET" class="max-w-xl mx-auto lg:mx-0 delay-200 animate-fade-in-up" style="animation-fill-mode: both;">
                        <div class="flex items-center bg-surface-light dark:bg-surface-dark rounded-full p-2 shadow-lg shadow-black/5 border border-border-light dark:border-border-dark">
                            <span class="material-symbols-outlined text-text-sec-light dark:text-text-sec-dark ml-4">search</span>
                            <input 
                                type="text" 
                                name="q" 
                                placeholder="Cari kuliner, resep, atau lokasi..."
                                class="flex-1 bg-transparent border-none focus:ring-0 text-text-main-light dark:text-text-main-dark placeholder-text-sec-light/50 px-4 py-3"
                            />
                            <button type="submit" class="px-6 py-3 bg-primary text-text-main-light rounded-full font-bold hover:brightness-95 transition-all">
                                Cari
                            </button>
                        </div>
                    </form>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center lg:justify-start gap-8 mt-10 delay-300 animate-fade-in-up" style="animation-fill-mode: both;">
                        <div class="text-center">
                            <p class="text-3xl font-black text-primary-dark">{{ $totalCategories }}+</p>
                            <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Kategori</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-black text-primary-dark">{{ $totalKuliners }}+</p>
                            <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Kuliner</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-black text-primary-dark">{{ $totalRecipes }}+</p>
                            <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Resep</p>
                        </div>
                    </div>
                </div>

                <!-- HeroImage Grid -->
                <div class="hidden lg:grid grid-cols-2 gap-4 animate-fade-in-up delay-200" style="animation-fill-mode: both;">
                    <div class="space-y-4">
                        <div class="aspect-[4/5] rounded-2xl bg-gradient-to-br from-primary/20 to-primary/40 overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                            @if($topRated->first() && $topRated->first()->image)
                            <img src="{{ asset('storage/' . $topRated->first()->image) }}" alt="" class="w-full h-full object-cover">
                            @else
                            <img src="{{ asset('images/hero_1.png') }}" alt="Nasi Goreng" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="aspect-square rounded-2xl bg-primary/20 overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                            @if($topRated->skip(1)->first() && $topRated->skip(1)->first()->image)
                            <img src="{{ asset('storage/' . $topRated->skip(1)->first()->image) }}" alt="" class="w-full h-full object-cover">
                            @else
                            <img src="{{ asset('images/hero_2.png') }}" alt="Sate Ayam" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>
                    <div class="space-y-4 pt-8">
                        <div class="aspect-square rounded-2xl bg-primary/30 overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                            @if($topRated->skip(2)->first() && $topRated->skip(2)->first()->image)
                            <img src="{{ asset('storage/' . $topRated->skip(2)->first()->image) }}" alt="" class="w-full h-full object-cover">
                            @else
                            <img src="{{ asset('images/hero_3.png') }}" alt="Rendang" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="aspect-[4/5] rounded-2xl bg-gradient-to-br from-primary/30 to-primary/50 overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                            @if($topRated->skip(3)->first() && $topRated->skip(3)->first()->image)
                            <img src="{{ asset('storage/' . $topRated->skip(3)->first()->image) }}" alt="" class="w-full h-full object-cover">
                            @else
                            <img src="{{ asset('images/hero_4.png') }}" alt="Soto Ayam" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-16 bg-surface-light dark:bg-surface-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-text-main-light dark:text-text-main-dark">Kategori Populer</h2>
                    <p class="text-text-sec-light dark:text-text-sec-dark mt-1">Jelajahi kuliner berdasarkan kategori favorit</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php
                    $catImages = ['cat_rice.png', 'cat_noodle.png', 'cat_chicken.png', 'cat_seafood.png', 'cat_snack.png', 'cat_drink.png'];
                @endphp
                @foreach($categories as $category)
                @php
                    $catImage = $catImages[$loop->index % count($catImages)];
                @endphp
                <a href="{{ route('kuliners.category', $category->slug) }}" class="group flex flex-col items-center p-6 bg-background-light dark:bg-background-dark rounded-2xl border border-border-light dark:border-border-dark hover:border-primary hover:shadow-lg transition-all">
                    <div class="size-24 rounded-full overflow-hidden mb-4 border-2 border-primary/20 group-hover:border-primary transition-all shadow-sm">
                        <img src="{{ asset('images/' . $catImage) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <h3 class="font-bold text-text-main-light dark:text-text-main-dark text-center group-hover:text-primary-dark transition-colors">{{ $category->name }}</h3>
                    <p class="text-xs text-text-sec-light dark:text-text-sec-dark mt-1">{{ $category->kuliners_count ?? 0 }} item</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Map Exploration Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-background-light dark:bg-background-dark">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-surface-light dark:bg-surface-dark rounded-[3rem] p-8 md:p-12 shadow-2xl border border-border-light dark:border-border-dark flex flex-col lg:flex-row items-center gap-12 overflow-hidden">
                <div class="flex-1 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary-dark font-bold text-sm">
                        <span class="material-symbols-outlined text-lg">map</span>
                        Peta Kuliner
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-text-main-light dark:text-text-main-dark leading-tight">
                        Jelajahi Cita Rasa <br/>
                        <span class="text-primary">Kota Surabaya</span>
                    </h2>
                    <p class="text-lg text-text-sec-light dark:text-text-sec-dark leading-relaxed">
                        Temukan lokasi kuliner legendaris dan hidden gem di setiap sudut kota Surabaya. Dari Surabaya Barat hingga Timur, semua ada di sini.
                    </p>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                        <a href="{{ route('kuliners.index') }}" class="px-8 py-4 bg-primary text-text-main-light rounded-full font-bold text-lg hover:brightness-105 transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                            Mulai Jelajah
                            <span class="material-symbols-outlined">explore</span>
                        </a>
                    </div>
                </div>
                <div class="flex-1 w-full max-w-lg lg:max-w-none relative group">
                    <div class="absolute inset-0 bg-primary/20 blur-3xl rounded-full transform group-hover:scale-110 transition-transform duration-700"></div>
                    <img src="{{ asset('images/map_surabaya.png') }}" alt="Peta Kuliner Surabaya" class="relative z-10 w-full h-auto drop-shadow-2xl transform group-hover:rotate-1 transition-transform duration-700 hover:scale-105">
                    
                    <!-- Floating Map Pins Animation -->
                    <div class="absolute top-1/4 left-1/4 z-20 animate-bounce delay-100">
                        <span class="material-symbols-outlined text-4xl text-red-500 drop-shadow-lg">location_on</span>
                    </div>
                    <div class="absolute bottom-1/3 right-1/3 z-20 animate-bounce delay-700">
                        <span class="material-symbols-outlined text-4xl text-primary-dark drop-shadow-lg">location_on</span>
                    </div>
                    <div class="absolute top-1/2 right-1/4 z-20 animate-bounce delay-300">
                        <span class="material-symbols-outlined text-4xl text-blue-500 drop-shadow-lg">location_on</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Rated Kuliners -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-text-main-light dark:text-text-main-dark">Rekomendasi Terbaik</h2>
                    <p class="text-text-sec-light dark:text-text-sec-dark mt-1">Kuliner dengan rating tertinggi dari komunitas</p>
                </div>
                <a href="{{ route('kuliners.index', ['sort' => 'rating']) }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-primary-dark hover:underline">
                    Lihat Semua
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($topRated as $kuliner)
                <a href="{{ route('kuliners.show', $kuliner->slug) }}" class="group bg-surface-light dark:bg-surface-dark rounded-2xl overflow-hidden border border-border-light dark:border-border-dark hover:border-primary hover:shadow-xl transition-all">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        @if($kuliner->image)
                        <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        @php
                            $fallbackImages = ['hero_1.png', 'hero_2.png', 'hero_3.png', 'hero_4.png', 'food_bakso.png', 'food_pempek.png', 'cat_rice.png', 'cat_noodle.png'];
                            // Use deterministic random based on ID for consistency
                            $seed = crc32($kuliner->id . $kuliner->name);
                            $randomImage = $fallbackImages[$seed % count($fallbackImages)];
                        @endphp
                        <img src="{{ asset('images/' . $randomImage) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute top-3 right-3 bg-white/90 dark:bg-black/70 backdrop-blur-sm text-text-main-light dark:text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-primary-dark">star</span>
                            {{ number_format($kuliner->average_rating, 1) }}
                        </div>
                        @if($kuliner->is_featured)
                        <div class="absolute top-3 left-3 bg-rose-500 text-white text-xs font-bold px-2 py-1 rounded-full">Featured</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary-dark transition-colors line-clamp-1">{{ $kuliner->name }}</h3>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark mt-1 line-clamp-1">{{ $kuliner->location }}</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xs bg-border-light dark:bg-border-dark text-text-sec-light dark:text-text-sec-dark px-2 py-1 rounded">{{ $kuliner->price_range }}</span>
                            <span class="text-xs text-text-sec-light dark:text-text-sec-dark">{{ $kuliner->total_reviews }} ulasan</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('kuliners.index', ['sort' => 'rating']) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full font-bold hover:border-primary transition-colors">
                    Lihat Semua Kuliner
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured -->
    @if($featured->count() > 0)
    <section class="py-16 bg-gradient-to-r from-primary/10 via-primary/5 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-text-main-light dark:text-text-main-dark">Pilihan Spesial</h2>
                    <p class="text-text-sec-light dark:text-text-sec-dark mt-1">Kuliner pilihan editor untuk Anda</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featured as $kuliner)
                <a href="{{ route('kuliners.show', $kuliner->slug) }}" class="group bg-surface-light dark:bg-surface-dark rounded-2xl overflow-hidden border border-border-light dark:border-border-dark hover:border-primary hover:shadow-xl transition-all">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        @if($kuliner->image)
                        <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        @php
                            $fallbackImages = ['cat_chicken.png', 'cat_seafood.png', 'food_bakso.png', 'hero_3.png', 'hero_4.png'];
                            $seed = crc32($kuliner->id . $kuliner->name);
                            $randomImage = $fallbackImages[$seed % count($fallbackImages)];
                        @endphp
                        <img src="{{ asset('images/' . $randomImage) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute top-3 left-3 bg-rose-500 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">favorite</span>
                            Pilihan
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary-dark transition-colors line-clamp-1">{{ $kuliner->name }}</h3>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark mt-1 line-clamp-1">{{ $kuliner->location }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Kuliners -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-text-main-light dark:text-text-main-dark">Terbaru</h2>
                    <p class="text-text-sec-light dark:text-text-sec-dark mt-1">Kuliner yang baru ditambahkan</p>
                </div>
                <a href="{{ route('kuliners.index', ['sort' => 'latest']) }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-primary-dark hover:underline">
                    Lihat Semua
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latest as $kuliner)
                <a href="{{ route('kuliners.show', $kuliner->slug) }}" class="group bg-surface-light dark:bg-surface-dark rounded-2xl overflow-hidden border border-border-light dark:border-border-dark hover:border-primary hover:shadow-xl transition-all">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        @if($kuliner->image)
                        <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        @php
                            $fallbackImages = ['cat_snack.png', 'cat_drink.png', 'hero_1.png', 'hero_2.png', 'food_pempek.png'];
                            $seed = crc32($kuliner->id . $kuliner->name);
                            $randomImage = $fallbackImages[$seed % count($fallbackImages)];
                        @endphp
                        <img src="{{ asset('images/' . $randomImage) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-full">
                            {{ $kuliner->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary-dark transition-colors line-clamp-1">{{ $kuliner->name }}</h3>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex items-center gap-1 text-primary-dark">
                                <span class="material-symbols-outlined text-[16px]">star</span>
                                <span class="text-sm font-bold">{{ number_format($kuliner->average_rating, 1) }}</span>
                            </div>
                            <span class="text-text-sec-light dark:text-text-sec-dark">•</span>
                            <span class="text-sm text-text-sec-light dark:text-text-sec-dark">{{ $kuliner->location }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Latest Recipes -->
    @if($latestRecipes->count() > 0)
    <section class="py-16 bg-surface-light dark:bg-surface-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-text-main-light dark:text-text-main-dark">Resep Terbaru</h2>
                    <p class="text-text-sec-light dark:text-text-sec-dark mt-1">Resep dari komunitas pecinta kuliner</p>
                </div>
                <a href="{{ route('recipes.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-primary-dark hover:underline">
                    Lihat Semua
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestRecipes as $recipe)
                <a href="{{ route('recipes.show', $recipe->slug) }}" class="group bg-background-light dark:bg-background-dark rounded-2xl overflow-hidden border border-border-light dark:border-border-dark hover:border-primary hover:shadow-xl transition-all">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        @php
                            $fallbackImages = ['cat_rice.png', 'cat_noodle.png', 'food_bakso.png', 'hero_3.png'];
                            $seed = crc32($recipe->id . $recipe->title);
                            $randomImage = $fallbackImages[$seed % count($fallbackImages)];
                        @endphp
                        <img src="{{ asset('images/' . $randomImage) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        @if($recipe->cooking_time)
                        <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">timer</span>
                            {{ $recipe->cooking_time }} menit
                        </div>
                        @endif
                        <div class="absolute top-3 left-3 px-2 py-1 rounded-full text-xs font-bold
                            {{ $recipe->difficulty === 'mudah' ? 'bg-green-500/80 text-white' : ($recipe->difficulty === 'sedang' ? 'bg-yellow-500/80 text-white' : 'bg-red-500/80 text-white') }}">
                            {{ $recipe->difficulty_label }}
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary-dark transition-colors line-clamp-1">{{ $recipe->title }}</h3>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark mt-1 line-clamp-2">{{ $recipe->description }}</p>
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-border-light dark:border-border-dark">
                            <div class="size-8 bg-primary/20 rounded-full flex items-center justify-center text-primary-dark font-bold text-sm">
                                {{ substr($recipe->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-text-main-light dark:text-text-main-dark truncate">{{ $recipe->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('recipes.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-full font-bold hover:border-primary transition-colors">
                    Lihat Semua Resep
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-text-main-light to-text-main-light/90 dark:from-text-main-light dark:to-text-main-light/80">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <span class="material-symbols-outlined text-6xl text-primary-dark mb-6">menu_book</span>
            <h2 class="text-3xl sm:text-4xl font-black font-serif text-white mb-4">Punya Resep Andalan?</h2>
            <p class="text-lg text-white/70 mb-8 max-w-2xl mx-auto">
                Bagikan resep favoritmu dan jadilah bagian dari komunitas kuliner Indonesia. Inspirasi jutaan orang dengan kreasi masakanmu!
            </p>
            @auth
            <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-text-main-light rounded-full font-bold text-lg hover:brightness-95 transition-all shadow-lg">
                <span class="material-symbols-outlined">edit</span>
                Tulis Resep Sekarang
            </a>
            @else
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-text-main-light rounded-full font-bold text-lg hover:brightness-95 transition-all shadow-lg">
                <span class="material-symbols-outlined">person_add</span>
                Daftar & Mulai Berbagi
            </a>
            @endauth
        </div>
    </section>
</x-app-layout>
