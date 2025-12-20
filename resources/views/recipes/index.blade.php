<x-app-layout>
    <div class="py-12 bg-background-light dark:bg-background-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="flex flex-col items-center gap-6 text-center py-6 mb-8">
                <h1 class="text-text-main-light dark:text-text-main-dark text-4xl sm:text-5xl font-black leading-tight tracking-[-0.033em]">
                    Temukan Resep <span class="text-primary drop-shadow-sm">Favoritmu</span>
                </h1>
                <div class="w-full max-w-2xl mt-2">
                    <form action="{{ route('recipes.index') }}" method="GET">
                        <label class="flex flex-col h-14 w-full shadow-lg shadow-black/5 rounded-full">
                            <div class="flex w-full flex-1 items-stretch rounded-full h-full bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-all overflow-hidden pl-6 pr-2">
                                <div class="text-text-sec-light dark:text-text-sec-dark flex items-center justify-center mr-2">
                                    <span class="material-symbols-outlined">search</span>
                                </div>
                                <input 
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
                                    class="flex w-full min-w-0 flex-1 bg-transparent text-text-main-light dark:text-text-main-dark placeholder:text-text-sec-light/50 px-2 text-base font-normal leading-normal border-none focus:outline-none focus:ring-0 h-full" 
                                    placeholder="Cari resep, bahan, atau koki..."
                                />
                                <button type="submit" class="px-4 text-primary hover:text-primary/80 flex items-center">
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </button>
                            </div>
                        </label>
                    </form>
                </div>
            </div>

            <!-- Filters & Sort -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 w-full sticky top-[80px] z-30 py-4 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-sm mb-6">
                <!-- Chips -->
                <div class="flex gap-3 overflow-x-auto no-scrollbar w-full md:w-auto pb-2 md:pb-0">
                    <a href="{{ route('recipes.index') }}" 
                       class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full px-6 shadow-sm transition-all active:scale-95 
                       {{ !request('difficulty') ? 'bg-primary text-[#1c1c0d] font-bold shadow-md scale-105' : 'bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary text-text-main-light dark:text-text-main-dark font-medium' }}">
                        <p class="text-sm leading-normal">Semua</p>
                    </a>
                    <a href="{{ route('recipes.index', ['difficulty' => 'mudah']) }}" 
                       class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full px-6 transition-all active:scale-95
                       {{ request('difficulty') == 'mudah' ? 'bg-primary text-[#1c1c0d] font-bold shadow-md scale-105' : 'bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary text-text-main-light dark:text-text-main-dark font-medium' }}">
                        <p class="text-sm leading-normal">Mudah</p>
                    </a>
                    <a href="{{ route('recipes.index', ['difficulty' => 'sedang']) }}" 
                       class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full px-6 transition-all active:scale-95
                       {{ request('difficulty') == 'sedang' ? 'bg-primary text-[#1c1c0d] font-bold shadow-md scale-105' : 'bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary text-text-main-light dark:text-text-main-dark font-medium' }}">
                        <p class="text-sm leading-normal">Sedang</p>
                    </a>
                    <a href="{{ route('recipes.index', ['difficulty' => 'sulit']) }}" 
                       class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full px-6 transition-all active:scale-95
                       {{ request('difficulty') == 'sulit' ? 'bg-primary text-[#1c1c0d] font-bold shadow-md scale-105' : 'bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary text-text-main-light dark:text-text-main-dark font-medium' }}">
                        <p class="text-sm leading-normal">Sulit</p>
                    </a>
                </div>
                <!-- Sort Dropdown -->
                <!-- Sort Dropdown (Custom UI) -->
                <div class="relative min-w-[180px] self-end md:self-auto group" id="sortDropdown">
                    <button type="button" onclick="toggleSortDropdown()" class="flex w-full items-center justify-between gap-2 rounded-full bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark px-4 py-2.5 text-sm font-medium text-text-main-light dark:text-text-main-dark shadow-sm hover:border-primary dark:hover:border-primary transition-all active:scale-95">
                        <span class="truncate">
                            @if(request('sort') == 'popular') Terpopuler
                            @elseif(request('sort') == 'quick') Tercepat
                            @else Terbaru
                            @endif
                        </span>
                        <span class="material-symbols-outlined text-[20px] text-text-sec-light dark:text-text-sec-dark transition-transform duration-300" id="sortDropdownArrow">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="sortDropdownMenu" class="absolute right-0 top-full mt-2 w-full min-w-[200px] origin-top-right rounded-2xl bg-surface-light dark:bg-surface-dark p-2 shadow-xl ring-1 ring-black/5 dark:ring-white/10 opacity-0 invisible scale-95 transition-all duration-200 z-50">
                        <a href="{{ route('recipes.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" class="flex w-full items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors hover:bg-primary/10 hover:text-primary {{ request('sort', 'newest') == 'newest' ? 'bg-primary/5 text-primary' : 'text-text-main-light dark:text-text-main-dark' }}">
                            <span class="material-symbols-outlined text-[18px]">access_time</span>
                            Terbaru
                            @if(request('sort', 'newest') == 'newest')
                            <span class="material-symbols-outlined text-[18px] ml-auto">check</span>
                            @endif
                        </a>
                        <a href="{{ route('recipes.index', array_merge(request()->query(), ['sort' => 'popular'])) }}" class="flex w-full items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors hover:bg-primary/10 hover:text-primary {{ request('sort') == 'popular' ? 'bg-primary/5 text-primary' : 'text-text-main-light dark:text-text-main-dark' }}">
                            <span class="material-symbols-outlined text-[18px]">trending_up</span>
                            Terpopuler
                            @if(request('sort') == 'popular')
                            <span class="material-symbols-outlined text-[18px] ml-auto">check</span>
                            @endif
                        </a>
                        <a href="{{ route('recipes.index', array_merge(request()->query(), ['sort' => 'quick'])) }}" class="flex w-full items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition-colors hover:bg-primary/10 hover:text-primary {{ request('sort') == 'quick' ? 'bg-primary/5 text-primary' : 'text-text-main-light dark:text-text-main-dark' }}">
                            <span class="material-symbols-outlined text-[18px]">timer</span>
                            Tercepat
                            @if(request('sort') == 'quick')
                            <span class="material-symbols-outlined text-[18px] ml-auto">check</span>
                            @endif
                        </a>
                    </div>
                </div>

                <script>
                function toggleSortDropdown() {
                    const menu = document.getElementById('sortDropdownMenu');
                    const arrow = document.getElementById('sortDropdownArrow');
                    
                    if (menu.classList.contains('invisible')) {
                        // Open
                        menu.classList.remove('invisible', 'opacity-0', 'scale-95');
                        arrow.classList.add('rotate-180');
                    } else {
                        // Close
                        menu.classList.add('invisible', 'opacity-0', 'scale-95');
                        arrow.classList.remove('rotate-180');
                    }
                }

                // Close when clicking outside
                document.addEventListener('click', function(event) {
                    const dropdown = document.getElementById('sortDropdown');
                    const menu = document.getElementById('sortDropdownMenu');
                    const arrow = document.getElementById('sortDropdownArrow');
                    
                    if (!dropdown.contains(event.target) && !menu.classList.contains('invisible')) {
                        menu.classList.add('invisible', 'opacity-0', 'scale-95');
                        arrow.classList.remove('rotate-180');
                    }
                });
                </script>
            </div>

            <!-- Recipe Grid -->
            @if($recipes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe->slug) }}" class="group flex flex-col bg-surface-light dark:bg-surface-dark rounded-[2rem] overflow-hidden border border-transparent hover:border-primary/50 hover:shadow-xl dark:hover:shadow-primary/5 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-[1.5rem] m-2">
                        @if($recipe->image)
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('{{ asset('storage/' . $recipe->image) }}');"></div>
                        @else
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center transition-transform duration-700 group-hover:scale-110">
                            <span class="material-symbols-outlined text-6xl text-primary/60">menu_book</span>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Difficulty Badge -->
                        <div class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md shadow-sm
                            {{ $recipe->difficulty === 'mudah' ? 'bg-green-500/90 text-white' : ($recipe->difficulty === 'sedang' ? 'bg-yellow-500/90 text-white' : 'bg-red-500/90 text-white') }}">
                            {{ $recipe->difficulty_label }}
                        </div>
                        
                        @if($recipe->cooking_time)
                        <div class="absolute bottom-3 left-4 text-white flex items-center gap-1.5 text-xs font-bold bg-black/40 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10">
                            <span class="material-symbols-outlined text-[16px]">timer</span>
                            <span>{{ $recipe->formatted_cooking_time }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="px-5 pb-5 pt-2 flex flex-col flex-1">
                        <h3 class="font-bold text-xl text-text-main-light dark:text-text-main-dark leading-tight line-clamp-2 group-hover:text-primary dark:group-hover:text-primary transition-colors mb-2">
                            {{ $recipe->title }}
                        </h3>
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark line-clamp-2 mb-6 leading-relaxed">
                            {{ $recipe->description }}
                        </p>
                        
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-border-light dark:border-border-dark">
                            @if($recipe->user->avatar)
                            <img src="{{ asset('storage/' . $recipe->user->avatar) }}" alt="{{ $recipe->user->name }}" class="size-8 rounded-full object-cover">
                            @else
                            <div class="size-8 bg-primary/20 rounded-full flex items-center justify-center text-primary-dark font-bold text-sm">
                                {{ substr($recipe->user->name, 0, 1) }}
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-text-main-light dark:text-text-main-dark truncate">{{ $recipe->user->name }}</p>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-text-sec-light dark:text-text-sec-dark">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                {{ $recipe->views }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($recipes->hasPages())
            <div class="flex justify-center mt-12">
                <div class="flex items-center gap-3 bg-surface-light dark:bg-surface-dark p-2 rounded-full shadow-sm border border-border-light dark:border-border-dark">
                    @if($recipes->onFirstPage())
                    <span class="size-10 flex items-center justify-center bg-background-light dark:bg-background-dark rounded-full text-text-sec-light opacity-50 cursor-not-allowed">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </span>
                    @else
                    <a href="{{ $recipes->previousPageUrl() }}" class="size-10 flex items-center justify-center bg-background-light dark:bg-background-dark rounded-full hover:bg-primary hover:text-black transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                    @endif

                    <span class="px-2 text-sm font-bold text-text-main-light dark:text-text-main-dark">
                        {{ $recipes->currentPage() }} / {{ $recipes->lastPage() }}
                    </span>

                    @if($recipes->hasMorePages())
                    <a href="{{ $recipes->nextPageUrl() }}" class="size-10 flex items-center justify-center bg-background-light dark:bg-background-dark rounded-full hover:bg-primary hover:text-black transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                    @else
                    <span class="size-10 flex items-center justify-center bg-background-light dark:bg-background-dark rounded-full text-text-sec-light opacity-50 cursor-not-allowed">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </span>
                    @endif
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="py-20 text-center flex flex-col items-center justify-center opacity-70">
                <div class="size-32 bg-surface-light dark:bg-surface-dark rounded-full flex items-center justify-center mb-6 border border-border-light dark:border-border-dark shadow-sm">
                    <span class="material-symbols-outlined text-6xl text-text-sec-light/40">menu_book</span>
                </div>
                <h3 class="text-2xl font-bold text-text-main-light dark:text-text-main-dark mb-2">Belum Ada Resep</h3>
                <p class="text-text-sec-light dark:text-text-sec-dark text-center max-w-md mb-8 leading-relaxed">
                    @if(request('q'))
                        Tidak ditemukan resep dengan kata kunci "{{ request('q') }}". <br/>Coba gunakan kata kunci yang lebih umum.
                    @else
                        Jadilah yang pertama membagikan resep andalanmu kepada komunitas!
                    @endif
                </p>
                @auth
                <a href="{{ route('recipes.create') }}" class="px-8 py-4 bg-primary text-black rounded-full font-bold text-lg hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    Tulis Resep Sekarang
                </a>
                @else
                <a href="{{ route('register') }}" class="px-8 py-4 bg-primary text-black rounded-full font-bold text-lg hover:shadow-lg hover:scale-105 transition-all">
                    Daftar & Mulai Berbagi
                </a>
                @endauth
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
