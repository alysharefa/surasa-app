<x-app-layout>

    <main class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Header -->
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-black mb-6">Hasil Pencarian</h1>
                
                <!-- Search Form -->
                <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 flex items-center bg-surface-light dark:bg-surface-dark rounded-full border border-border-light dark:border-border-dark focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                        <span class="material-symbols-outlined text-text-sec-light ml-4">search</span>
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}" 
                            placeholder="Cari kuliner, resep, atau lokasi..."
                            class="flex-1 bg-transparent border-none focus:ring-0 text-text-main-light dark:text-text-main-dark placeholder-text-sec-light/50 px-4 py-3"
                        />
                    </div>
                    <select name="category" class="px-6 py-3 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full focus:border-primary focus:ring-2 focus:ring-primary/20 text-text-main-light dark:text-text-main-dark">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Sort Dropdown -->
                    <select name="sort" class="px-6 py-3 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full focus:border-primary focus:ring-2 focus:ring-primary/20 text-text-main-light dark:text-text-main-dark">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
    
                    <button type="submit" class="px-8 py-3 bg-primary text-text-main-light rounded-full font-bold hover:brightness-95 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">search</span>
                        Cari
                    </button>
                </form>
            </div>
    
            <!-- Results Info -->
            @if($query || $categoryId)
            <div class="mb-6 flex items-center gap-2 text-text-sec-light dark:text-text-sec-dark">
                <span class="material-symbols-outlined">info</span>
                <p>
                    Ditemukan <strong class="text-text-main-light dark:text-text-main-dark">{{ $kuliners->total() }}</strong> hasil
                    @if($query) untuk "<strong class="text-primary">{{ $query }}</strong>" @endif
                </p>
            </div>
            @endif
    
            <!-- Results Grid -->
            @if($kuliners->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($kuliners as $kuliner)
                <a href="{{ route('kuliners.show', $kuliner->slug) }}" class="group bg-surface-light dark:bg-surface-dark rounded-[2rem] p-3 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-primary/30 flex flex-col h-full">
                    <!-- Image Container -->
                    <div class="relative h-64 w-full rounded-[1.5rem] overflow-hidden mb-4 shrink-0">
                        @if($kuliner->image)
                        <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        @else
                        @php
                            $fallbackImages = ['hero_1.png', 'hero_2.png', 'hero_3.png', 'hero_4.png', 'food_bakso.png', 'food_pempek.png', 'cat_rice.png', 'cat_noodle.png', 'cat_chicken.png', 'cat_seafood.png'];
                             // Use deterministic random based on ID for consistency
                            $seed = crc32($kuliner->id . $kuliner->name);
                            $randomImage = $fallbackImages[$seed % count($fallbackImages)];
                        @endphp
                        <img src="{{ asset('images/' . $randomImage) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        @endif
                        
                        <!-- Rating Badge -->
                        <div class="absolute top-3 right-3 bg-surface-light/90 dark:bg-surface-dark/90 backdrop-blur-md text-text-main-light dark:text-text-main-dark text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1 shadow-sm border border-black/5">
                            <span class="material-symbols-outlined text-[16px] text-yellow-500 fill-current">star</span>
                            {{ number_format($kuliner->average_rating, 1) }}
                        </div>
                    </div>
    
                    <!-- Content -->
                    <div class="px-3 pb-2 flex-grow flex flex-col">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h3 class="font-bold text-xl text-text-main-light dark:text-text-main-dark leading-tight line-clamp-2 group-hover:text-primary transition-colors">
                                {{ $kuliner->name }}
                            </h3>
                            <span class="shrink-0 text-xs font-bold bg-background-light dark:bg-background-dark text-text-sec-light dark:text-text-sec-dark px-2.5 py-1 rounded-lg border border-border-light dark:border-border-dark">
                                {{ $kuliner->price_range }}
                            </span>
                        </div>
                        
                        <p class="text-text-sec-light dark:text-text-sec-dark text-sm mb-4 line-clamp-2 leading-relaxed">
                            {{ $kuliner->address ?? $kuliner->location }}
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-dashed border-border-light dark:border-border-dark flex items-center justify-between text-xs font-medium text-text-sec-light/80 dark:text-text-sec-dark/80">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">schedule</span>
                                {{ $kuliner->opening_hours ?? 'Buka' }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">location_on</span>
                                {{ $kuliner->location }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
    
            <!-- Pagination -->
            @if($kuliners->hasPages())
            <div class="mt-12 flex justify-center">
                <div class="flex items-center gap-2">
                    @if($kuliners->onFirstPage())
                    <span class="px-4 py-2 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-sec-light rounded-full cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </span>
                    @else
                    <a href="{{ $kuliners->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </a>
                    @endif
    
                    <span class="px-4 py-2 text-sm font-medium text-text-sec-light dark:text-text-sec-dark">
                        Halaman {{ $kuliners->currentPage() }} dari {{ $kuliners->lastPage() }}
                    </span>
    
                    @if($kuliners->hasMorePages())
                    <a href="{{ $kuliners->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </a>
                    @else
                    <span class="px-4 py-2 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-sec-light rounded-full cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </span>
                    @endif
                </div>
            </div>
            @endif
    
            @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-32 h-32 bg-surface-light dark:bg-surface-dark rounded-full flex items-center justify-center mb-6 border border-border-light dark:border-border-dark">
                    <span class="material-symbols-outlined text-6xl text-text-sec-light/30">search_off</span>
                </div>
                <h3 class="text-2xl font-bold mb-2">Tidak Ada Hasil</h3>
                <p class="text-text-sec-light dark:text-text-sec-dark text-center max-w-md mb-6">
                    Tidak ditemukan kuliner untuk pencarian Anda. Coba kata kunci lain atau ubah filter kategori.
                </p>
                <a href="{{ route('kuliners.index') }}" class="px-6 py-3 bg-primary text-text-main-light rounded-full font-bold hover:brightness-95 transition-all">
                    Lihat Semua Kuliner
                </a>
            </div>
            @endif
        </div>
    </main>
    
    </x-app-layout>
    