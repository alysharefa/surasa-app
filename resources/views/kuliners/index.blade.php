<x-app-layout>
    <div class="py-12 bg-background-light dark:bg-background-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Hero & Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-12">
                <div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-text-main-light dark:text-text-main-dark mb-4">
                        Temukan <br/>
                        <span class="relative inline-block text-primary">
                            Cita Rasa
                            <span class="absolute bottom-2 left-0 w-full h-3 bg-primary/20 -z-10 rounded-full"></span>
                        </span>
                        Terbaik Sekitarmu.
                    </h2>
                    <p class="text-lg text-text-sec-light dark:text-text-sec-dark max-w-lg">
                        Jelajahi kuliner permata lokal, hidangan terbaik, dan harta karun tersembunyi di area Anda.
                    </p>
                </div>

                <!-- Search Bar -->
                <div class="w-full md:w-auto md:min-w-[400px]">
                    <form action="{{ route('kuliners.index') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <label class="flex items-center w-full h-14 bg-surface-light dark:bg-surface-dark rounded-full px-6 shadow-md border border-border-light dark:border-border-dark focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/50 transition-all">
                            <span class="material-symbols-outlined text-text-sec-light dark:text-text-sec-dark mr-3">search</span>
                            <input 
                                class="w-full bg-transparent border-none focus:ring-0 text-base px-0 text-text-main-light dark:text-text-main-dark placeholder-text-sec-light/50" 
                                placeholder="Cari Nasi Goreng, Bakso..." 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                            />
                            <button type="submit" class="ml-2 bg-primary text-black rounded-full p-2 hover:opacity-80 transition-opacity flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </button>
                        </label>
                    </form>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="mb-10 px-1">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <h3 class="text-xl font-bold text-text-main-light dark:text-text-main-dark">Kategori</h3>
                    
                    <div class="flex items-center gap-4">
                        <!-- Location Dropdown (Custom UI) -->
                        <div x-data="{ 
                            open: false, 
                            selected: '{{ request('location') }}',
                            select(val) {
                                this.selected = val;
                                this.open = false;
                                // Wait for x-model to update hidden input then submit
                                this.$nextTick(() => { $refs.locationForm.submit() });
                            }
                        }" class="relative min-w-[180px]">
                            
                            <form action="{{ route('kuliners.index') }}" method="GET" x-ref="locationForm">
                                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                                <input type="hidden" name="location" :value="selected">

                                <!-- Trigger Button -->
                                <button type="button" @click="open = !open" @click.outside="open = false" 
                                    class="w-full flex items-center justify-between gap-2 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full py-2.5 pl-4 pr-3 text-sm font-bold shadow-sm hover:border-primary focus:ring-2 focus:ring-primary/50 transition-all text-text-main-light dark:text-text-main-dark">
                                    <div class="flex items-center gap-2 truncate">
                                        <span class="material-symbols-outlined text-primary text-[20px]">location_on</span>
                                        <span x-text="selected ? selected : 'Semua Lokasi'" class="truncate"></span>
                                    </div>
                                    <span class="material-symbols-outlined text-[20px] text-text-sec-light transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                                </button>
                            </form>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute z-50 top-full mt-2 w-full min-w-[220px] right-0 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-2xl shadow-xl max-h-60 overflow-y-auto py-1"
                                 style="display: none;">
                                
                                <button type="button" @click="select('')" 
                                    class="w-full text-left px-4 py-2.5 text-sm font-medium hover:bg-primary/10 hover:text-primary transition-colors flex items-center justify-between group"
                                    :class="!selected ? 'text-primary bg-primary/5' : 'text-text-main-light dark:text-text-main-dark'">
                                    <span>Semua Lokasi</span>
                                    <span x-show="!selected" class="material-symbols-outlined text-[18px]">check</span>
                                </button>

                                @foreach($locations as $loc)
                                <button type="button" @click="select('{{ $loc }}')" 
                                    class="w-full text-left px-4 py-2.5 text-sm font-medium hover:bg-primary/10 hover:text-primary transition-colors flex items-center justify-between group"
                                    :class="selected === '{{ $loc }}' ? 'text-primary bg-primary/5' : 'text-text-main-light dark:text-text-main-dark'">
                                    <span>{{ $loc }}</span>
                                    <span x-show="selected === '{{ $loc }}'" class="material-symbols-outlined text-[18px]">check</span>
                                </button>
                                @endforeach
                            </div>
                        </div>

                        @if(request('search') || request('category') || request('sort') || request('location'))
                        <a href="{{ route('kuliners.index') }}" class="text-sm font-bold text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-2 rounded-full transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                            <span class="hidden sm:inline">Reset</span>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar">
                    <a href="{{ route('kuliners.index', request()->except('category', 'page')) }}" 
                       class="whitespace-nowrap px-6 py-2.5 rounded-full font-medium text-sm transition-all shadow-sm
                       {{ !request('category') 
                            ? 'bg-text-main-light dark:bg-white text-white dark:text-text-main-light shadow-lg scale-105' 
                            : 'bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-sec-light dark:text-text-sec-dark hover:border-primary hover:bg-primary/5' }}">
                        Semua
                    </a>
                    
                    @foreach($categories as $category)
                    <a href="{{ route('kuliners.index', ['category' => $category->id] + request()->except('category', 'page')) }}" 
                       class="whitespace-nowrap px-6 py-2.5 rounded-full font-medium text-sm transition-all shadow-sm
                       {{ request('category') == $category->id 
                            ? 'bg-text-main-light dark:bg-white text-white dark:text-text-main-light shadow-lg scale-105' 
                            : 'bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-sec-light dark:text-text-sec-dark hover:border-primary hover:bg-primary/5' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Culinary Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($kuliners as $kuliner)
                <a href="{{ route('kuliners.show', $kuliner->slug) }}" class="group bg-surface-light dark:bg-surface-dark rounded-[2rem] p-3 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-primary/30 flex flex-col h-full">
                    <!-- Image Container -->
                    <div class="relative h-64 w-full rounded-[1.5rem] overflow-hidden mb-4 shrink-0">
                        @if($kuliner->image)
                        <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        @else
                        @php
                            $fallbackImages = ['hero_1.png', 'hero_2.png', 'hero_3.png', 'hero_4.png', 'food_bakso.png', 'food_pempek.png', 'cat_rice.png', 'cat_noodle.png', 'cat_chicken.png', 'cat_seafood.png'];
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
                            {{ $kuliner->address }}
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
                @empty
                <div class="col-span-full py-20 text-center flex flex-col items-center justify-center opacity-60">
                    <div class="size-24 rounded-full bg-surface-light dark:bg-surface-dark flex items-center justify-center mb-4 border border-border-light dark:border-border-dark">
                        <span class="material-symbols-outlined text-4xl text-text-sec-light">no_meals</span>
                    </div>
                    <h3 class="text-xl font-bold text-text-main-light dark:text-text-main-dark">Tidak Ada Kuliner Ditemukan</h3>
                    <p class="text-text-sec-light dark:text-text-sec-dark mt-2">Coba sesuaikan pencarian atau filter Anda.</p>
                    <a href="{{ route('kuliners.index') }}" class="mt-6 px-6 py-2 bg-primary text-black rounded-full font-bold text-sm hover:brightness-95 transition-all">
                        Reset Filter
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-20 flex justify-center">
                {{ $kuliners->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
