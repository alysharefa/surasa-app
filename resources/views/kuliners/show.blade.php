<x-app-layout>
    <div class="bg-background-light dark:bg-background-dark min-h-screen py-8">
        <main class="w-full max-w-[1280px] mx-auto px-4 md:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <div class="flex flex-wrap items-center gap-2 mb-6 text-sm md:text-base">
                <a class="text-text-sec-light dark:text-text-sec-dark hover:underline" href="{{ route('home') }}">Beranda</a>
                <span class="text-text-sec-light dark:text-text-sec-dark">/</span>
                <a class="text-text-sec-light dark:text-text-sec-dark hover:underline" href="{{ route('kuliners.index') }}">Kuliner</a>
                <span class="text-text-sec-light dark:text-text-sec-dark">/</span>
                @if($kuliner->category)
                <a class="text-text-sec-light dark:text-text-sec-dark hover:underline" href="{{ route('kuliners.index', ['category' => $kuliner->category->id]) }}">{{ $kuliner->category->name }}</a>
                <span class="text-text-sec-light dark:text-text-sec-dark">/</span>
                @endif
                <span class="font-medium text-text-main-light dark:text-text-main-dark">{{ $kuliner->name }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 xl:gap-12">
                <!-- Left Column: Content -->
                <div class="flex flex-col gap-8">
                    <!-- Header Section -->
                    <div class="flex flex-col gap-4">
                        <!-- Hero Image -->
                        <div class="relative w-full aspect-[16/9] md:aspect-[21/9] lg:aspect-[16/9] rounded-[2rem] overflow-hidden shadow-sm group">
                            @if($kuliner->image)
                            <img 
                                src="{{ asset('storage/' . $kuliner->image) }}" 
                                alt="{{ $kuliner->name }}" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            />
                            @else
                            @php
                                $fallbackImages = ['hero_1.png', 'hero_2.png', 'hero_3.png', 'hero_4.png', 'food_bakso.png', 'food_pempek.png', 'cat_rice.png', 'cat_noodle.png', 'cat_chicken.png', 'cat_seafood.png'];
                                // Use a deterministic hash of the ID to select the same image for the same kuliner every time
                                $seed = crc32($kuliner->id . $kuliner->name);
                                $randomImage = $fallbackImages[$seed % count($fallbackImages)];
                            @endphp
                            <img 
                                src="{{ asset('images/' . $randomImage) }}" 
                                alt="{{ $kuliner->name }}" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            />
                            @endif
                            <div class="absolute top-4 right-4 bg-white/90 dark:bg-black/80 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm">
                                <span class="material-symbols-outlined fill text-primary-dark text-lg">star</span>
                                <span class="text-sm font-bold">{{ number_format($kuliner->average_rating, 1) }}</span>
                                <span class="text-xs text-text-sec-light dark:text-text-sec-dark">({{ $kuliner->total_reviews }})</span>
                            </div>
                            @if($kuliner->price_range)
                            <div class="absolute bottom-4 left-4 bg-black/60 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-sm border border-white/10">
                                {{ $kuliner->price_range }}
                            </div>
                            @endif
                        </div>

                        <!-- Title & Meta -->
                        <div class="flex flex-col gap-3 mt-2">
                            <div class="flex flex-wrap gap-2">
                                @if($kuliner->category)
                                <span class="px-3 py-1 rounded-full bg-primary/20 text-text-main-light dark:text-primary-dark text-xs font-bold tracking-wide uppercase">{{ $kuliner->category->name }}</span>
                                @endif
                                <span class="px-3 py-1 rounded-full bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-sec-light dark:text-text-sec-dark text-xs font-bold tracking-wide uppercase">{{ $kuliner->location }}</span>
                            </div>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-text-main-light dark:text-text-main-dark leading-tight">
                                {{ $kuliner->name }}
                            </h1>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-lg dark:prose-invert max-w-none text-text-main-light dark:text-text-main-dark/90 leading-relaxed">
                        <p class="whitespace-pre-line">{{ $kuliner->description }}</p>
                        
                        <div class="grid md:grid-cols-2 gap-4 mt-8 not-prose">
                            @if($kuliner->address)
                            <div class="p-5 bg-surface-light dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark flex items-start gap-3">
                                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary-dark shrink-0">
                                    <span class="material-symbols-outlined">location_on</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm mb-1 text-text-main-light dark:text-text-main-dark">Alamat</h4>
                                    <p class="text-sm text-text-sec-light dark:text-text-sec-dark">{{ $kuliner->address }}</p>
                                </div>
                            </div>
                            @endif

                            @if($kuliner->opening_hours)
                            <div class="p-5 bg-surface-light dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark flex items-start gap-3">
                                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary-dark shrink-0">
                                    <span class="material-symbols-outlined">schedule</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm mb-1 text-text-main-light dark:text-text-main-dark">Jam Buka</h4>
                                    <p class="text-sm text-text-sec-light dark:text-text-sec-dark">{{ $kuliner->opening_hours }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div id="reviews" class="mt-8 pt-8 border-t border-border-light dark:border-border-dark scroll-mt-24">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold text-text-main-light dark:text-text-main-dark">Ulasan & Rating</h3>
                        </div>

                        <!-- Rating Summary -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark mb-8">
                            <div class="flex flex-col md:flex-row items-center gap-8">
                                <!-- Big Rating -->
                                <div class="flex flex-col items-center justify-center text-center min-w-[120px]">
                                    <span class="text-6xl font-black text-text-main-light dark:text-text-main-dark">{{ number_format($kuliner->average_rating, 1) }}</span>
                                    <div class="flex text-yellow-500 my-2">
                                        @for($i=1; $i<=5; $i++)
                                        <span class="material-symbols-outlined text-xl {{ $i <= round($kuliner->average_rating) ? 'fill' : '' }}">star</span>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">{{ $kuliner->total_reviews }} Ulasan</span>
                                </div>

                                <!-- Progress Bars -->
                                <div class="flex-1 w-full space-y-2">
                                    @foreach($ratingDistribution as $star => $data)
                                    <div class="flex items-center gap-3 text-sm">
                                        <div class="flex items-center gap-1 w-12 shrink-0 font-bold text-text-main-light dark:text-text-main-dark">
                                            <span>{{ $star }}</span>
                                            <span class="material-symbols-outlined text-xs text-yellow-500 fill">star</span>
                                        </div>
                                        <div class="flex-1 h-3 bg-background-light dark:bg-background-dark rounded-full overflow-hidden">
                                            <div class="h-full bg-yellow-400 rounded-full transition-all duration-1000 ease-out" style="width: {{ $data['percentage'] }}%"></div>
                                        </div>
                                        <span class="w-14 text-right text-xs text-text-sec-light dark:text-text-sec-dark font-bold flex justify-end items-center gap-1">
                                            {{ $data['count'] }} 
                                            <span class="text-[10px] opacity-70">Ulasan</span>
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            @auth
                            <div class="mt-8 pt-6 border-t border-border-light dark:border-border-dark flex justify-center">
                                <button onclick="document.getElementById('reviewForm').classList.toggle('hidden')" class="px-8 py-3 bg-text-main-light dark:bg-white text-white dark:text-black rounded-full font-bold hover:opacity-90 transition-all shadow-lg flex items-center gap-2">
                                    <span class="material-symbols-outlined">rate_review</span>
                                    Tulis Ulasan Anda
                                </button>
                            </div>
                            
                            <!-- Hidden Review Form -->
                            <div id="reviewForm" class="hidden mt-6 animate-fade-in-up">
                                <form action="{{ route('comments.store', $kuliner->id) }}" method="POST" class="bg-background-light dark:bg-background-dark p-6 rounded-2xl">
                                    @csrf
                                    <h4 class="font-bold mb-4 text-text-main-light dark:text-text-main-dark">Bagikan pengalaman Anda</h4>
                                    
                                    <div class="mb-6">
                                        <label class="block text-sm font-bold text-text-sec-light dark:text-text-sec-dark mb-2">Rating Kepuasan</label>
                                        <div class="flex items-center gap-4">
                                            <div class="flex flex-row-reverse justify-end gap-1.5 group">
                                                @for($i=5; $i>=1; $i--)
                                                <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="peer hidden" required onchange="updateRatingText({{$i}})" />
                                                <label for="star{{$i}}" class="material-symbols-outlined text-4xl cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors peer-checked:fill hover:fill peer-hover:fill">star</label>
                                                @endfor
                                            </div>
                                            <span id="ratingText" class="text-sm font-bold text-primary animate-fade-in-up"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label for="content" class="block text-sm font-bold text-text-sec-light dark:text-text-sec-dark mb-2">Ulasan</label>
                                        <textarea name="content" id="content" rows="4" class="w-full rounded-xl border-border-light dark:border-border-dark bg-white dark:bg-surface-dark focus:ring-primary focus:border-primary transition-all" placeholder="Ceritakan pengalaman kuliner Anda di sini..." required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="px-6 py-2 bg-primary text-black font-bold rounded-lg hover:brightness-105">Kirim Ulasan</button>
                                </form>
                            </div>
                            @endauth
                        </div>
                        
                        <!-- Reviews List -->
                        <div class="space-y-6">
                            @if(isset($kuliner->comments) && $kuliner->comments->count() > 0)
                                @foreach($kuliner->comments as $comment)
                                <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl border border-border-light dark:border-border-dark">
                                    <div class="flex items-center gap-3 mb-3">
                                        @if($comment->user->avatar)
                                        <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="size-10 rounded-full object-cover">
                                        @else
                                        <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center font-bold text-text-main-light text-sm uppercase">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-sm text-text-main-light dark:text-text-main-dark">{{ $comment->user->name }}</h4>
                                            <div class="flex text-yellow-500 text-[10px] gap-0.5">
                                                @for($i=1; $i<=5; $i++)
                                                <span class="material-symbols-outlined text-sm {{ $i <= $comment->rating ? 'fill' : '' }}">star</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="ml-auto text-xs text-text-sec-light dark:text-text-sec-dark">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-text-sec-light dark:text-text-sec-dark text-sm leading-relaxed">{{ $comment->content }}</p>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-10 bg-surface-light dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark">
                                    <span class="material-symbols-outlined text-4xl text-text-sec-light/30">reviews</span>
                                    <p class="text-text-sec-light dark:text-text-sec-dark mt-2">Belum ada ulasan.</p>
                                    @auth
                                    <button onclick="document.getElementById('reviewForm').classList.toggle('hidden'); document.getElementById('reviewForm').scrollIntoView({behavior: 'smooth'})" class="text-primary font-bold text-sm mt-2 hover:underline">Jadilah yang pertama mengulas!</button>
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sticky Sidebar -->
                <div class="relative">
                    <div class="sticky top-24 flex flex-col gap-6">
                        <!-- Action Card -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm flex flex-col gap-6">
                            <div class="flex justify-between items-end border-b border-border-light dark:border-border-dark pb-6">
                                <div class="flex flex-col">
                                    <span class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Kisaran Harga</span>
                                    <div class="flex items-baseline gap-1 mt-1">
                                        <span class="text-2xl font-black text-text-main-light dark:text-text-main-dark">{{ $kuliner->price_range ?? '$-$$$' }}</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-full">
                                    Buka
                                </span>
                            </div>
                            <div class="flex flex-col gap-3">
                                @php
                                    $mapQuery = $kuliner->latitude && $kuliner->longitude 
                                        ? $kuliner->latitude . ',' . $kuliner->longitude 
                                        : urlencode($kuliner->name . ' ' . $kuliner->address);
                                    $directionUrl = "https://www.google.com/maps/dir/?api=1&destination={$mapQuery}";
                                    $locationUrl = "https://www.google.com/maps/search/?api=1&query={$mapQuery}";
                                @endphp

                                <a href="{{ $directionUrl }}" target="_blank" class="w-full py-3.5 bg-primary text-text-main-light font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">map</span>
                                    Petunjuk Arah
                                </a>
                                
                                @auth
                                <form action="{{ route('kuliners.like', $kuliner->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3.5 border border-border-light dark:border-border-dark font-bold rounded-xl transition-colors flex items-center justify-center gap-2 {{ $isLiked ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 border-red-200 dark:border-red-800' : 'bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark hover:bg-gray-50 dark:hover:bg-neutral-800' }}">
                                        <span class="material-symbols-outlined {{ $isLiked ? 'fill' : '' }}">favorite</span>
                                        {{ $isLiked ? 'Disukai' : 'Suka Kuliner Ini' }}
                                    </button>
                                </form>
                                @else
                                <a href="{{ route('login') }}" class="w-full py-3.5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">favorite</span>
                                    Suka Kuliner Ini
                                </a>
                                @endauth

                                <a href="{{ route('kuliners.index') }}" class="py-3.5 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold rounded-xl hover:bg-gray-100 dark:hover:bg-neutral-800 transition-colors flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">arrow_back</span>
                                    Kembali
                                </a>
                            </div>
                        </div>

                        <!-- Location Map -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm">
                            <h3 class="font-bold mb-4 text-text-main-light dark:text-text-main-dark">Lokasi</h3>
                            <a href="{{ $locationUrl }}" target="_blank" class="block w-full aspect-square bg-background-light dark:bg-background-dark rounded-xl overflow-hidden relative group cursor-pointer border border-border-light dark:border-border-dark transition-all hover:ring-2 hover:ring-primary/50">
                                <img src="{{ asset('images/map_surabaya.png') }}" alt="Peta Lokasi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="size-8 bg-primary/20 rounded-full animate-ping absolute"></div>
                                    <span class="material-symbols-outlined text-primary-dark text-4xl drop-shadow-md relative z-10">location_on</span>
                                </div>
                            </a>
                            <p class="mt-4 text-sm text-text-sec-light dark:text-text-sec-dark font-medium leading-relaxed">
                                {{ $kuliner->address }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>

<script>
function updateRatingText(rating) {
    const texts = {
        1: 'Sangat Buruk 😡',
        2: 'Kurang Enak 😞',
        3: 'Cukup Oke 😐',
        4: 'Enak! 😋',
        5: 'Luar Biasa! 😍'
    };
    const textEl = document.getElementById('ratingText');
    if(textEl) {
        textEl.innerText = texts[rating];
        textEl.classList.remove('animate-fade-in-up');
        void textEl.offsetWidth; // trigger reflow
        textEl.classList.add('animate-fade-in-up');
    }
}
</script>
