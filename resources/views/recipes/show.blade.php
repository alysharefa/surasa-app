<x-app-layout>
    <div class="bg-background-light dark:bg-background-dark min-h-screen py-8">
        <main class="w-full max-w-[1280px] mx-auto px-4 md:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <div class="flex flex-wrap items-center gap-2 mb-6 text-sm md:text-base">
                <a class="text-text-sec-light dark:text-text-sec-dark hover:underline" href="{{ route('home') }}">Beranda</a>
                <span class="text-text-sec-light dark:text-text-sec-dark">/</span>
                <a class="text-text-sec-light dark:text-text-sec-dark hover:underline" href="{{ route('recipes.index') }}">Resep</a>
                <span class="text-text-sec-light dark:text-text-sec-dark">/</span>
                <span class="font-medium text-text-main-light dark:text-text-main-dark">{{ $recipe->title }}</span>
            </div>

            <!-- Hero Section -->
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 mb-12">
                <!-- Image Column -->
                <div class="w-full lg:w-3/5">
                    <div class="relative w-full aspect-[4/3] rounded-[2rem] overflow-hidden shadow-sm group border border-border-light dark:border-border-dark">
                        <div class="absolute top-4 right-4 z-10 flex gap-2">
                            <button onclick="shareRecipe('{{ route('recipes.show', $recipe->slug) }}')" class="bg-white/90 dark:bg-black/80 backdrop-blur-sm p-3 rounded-full hover:bg-primary transition-all duration-300 shadow-lg group/btn text-text-main-light dark:text-text-main-dark active:scale-90">
                                <span class="material-symbols-outlined group-hover/btn:scale-110 transition-transform">share</span>
                            </button>
                        </div>
                        @if($recipe->image)
                        <div class="w-full h-full bg-center bg-no-repeat bg-cover transform group-hover:scale-105 transition-transform duration-700" style="background-image: url('{{ asset('storage/' . $recipe->image) }}');"></div>
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center">
                            <span class="material-symbols-outlined text-8xl text-primary/60">menu_book</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Content Column -->
                <div class="w-full lg:w-2/5 flex flex-col justify-center gap-6">
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-2">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                                {{ $recipe->difficulty === 'mudah' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                                   ($recipe->difficulty === 'sedang' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 
                                   'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                                {{ $recipe->difficulty_label }}
                            </span>
                            @if($recipe->is_approved)
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                <span class="material-symbols-outlined text-sm mr-1">verified</span> Verified
                            </span>
                            @endif
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-text-main-light dark:text-text-main-dark">
                            {{ $recipe->title }}
                        </h1>
                        <p class="text-lg text-text-sec-light dark:text-text-sec-dark leading-relaxed font-medium">
                            {{ $recipe->description }}
                        </p>
                    </div>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center gap-x-8 gap-y-4 py-6 border-y border-border-light dark:border-border-dark">
                        <div class="flex items-center gap-2 text-text-main-light dark:text-text-main-dark">
                            <span class="material-symbols-outlined text-primary">visibility</span>
                            <span class="text-sm font-bold">{{ $recipe->views }} views</span>
                        </div>
                        <div class="w-px h-8 bg-border-light dark:border-border-dark hidden sm:block"></div>
                        <div class="flex gap-8">
                            @if($recipe->prep_time)
                            <div class="flex flex-col">
                                <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-bold uppercase tracking-wider mb-0.5">Persiapan</span>
                                <span class="text-sm font-bold text-text-main-light dark:text-text-main-dark">{{ $recipe->prep_time }} menit</span>
                            </div>
                            @endif
                            @if($recipe->cooking_time)
                            <div class="flex flex-col">
                                <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-bold uppercase tracking-wider mb-0.5">Memasak</span>
                                <span class="text-sm font-bold text-text-main-light dark:text-text-main-dark">{{ $recipe->cooking_time }} menit</span>
                            </div>
                            @endif
                            @if($recipe->servings)
                            <div class="flex flex-col">
                                <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-bold uppercase tracking-wider mb-0.5">Porsi</span>
                                <span class="text-sm font-bold text-text-main-light dark:text-text-main-dark">{{ $recipe->servings }} orang</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Author & Actions -->
                    <div class="flex flex-col gap-6">
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark">
                            @if($recipe->user->avatar)
                            <img src="{{ asset('storage/' . $recipe->user->avatar) }}" alt="{{ $recipe->user->name }}" class="size-12 rounded-full object-cover border border-border-light dark:border-border-dark">
                            @else
                            <div class="size-12 rounded-full bg-primary/20 flex items-center justify-center font-bold text-primary text-xl">
                                {{ substr($recipe->user->name, 0, 1) }}
                            </div>
                            @endif
                            <div class="flex flex-col">
                                <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-medium uppercase tracking-wider">Resep oleh</span>
                                <span class="text-base font-bold text-text-main-light dark:text-text-main-dark">{{ $recipe->user->name }}</span>
                            </div>
                            <span class="ml-auto text-xs text-text-sec-light dark:text-text-sec-dark font-medium px-3 py-1 bg-background-light dark:bg-background-dark rounded-full">{{ $recipe->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Cook Mode Button -->
                        <button onclick="openCookMode()" class="w-full py-4 rounded-xl bg-primary text-black font-black text-lg hover:brightness-105 hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined text-[28px]">play_circle</span>
                            MULAI MASAK
                        </button>

                        <div class="grid grid-cols-3 gap-2">
                            @auth
                            <form action="{{ route('bookmarks.toggle', $recipe->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full h-full py-3.5 rounded-xl border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 active:scale-95 transition-all flex flex-col items-center justify-center gap-1 {{ $isBookmarked ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800' : 'bg-surface-light dark:bg-surface-dark' }}">
                                    <span class="material-symbols-outlined {{ $isBookmarked ? 'fill' : '' }} text-2xl">{{ $isBookmarked ? 'bookmark_added' : 'bookmark_add' }}</span>
                                    <span class="text-xs">Simpan</span>
                                </button>
                            </form>
                            
                            <form action="{{ route('recipes.like', $recipe->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full h-full py-3.5 rounded-xl border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 active:scale-95 transition-all flex flex-col items-center justify-center gap-1 {{ $isLiked ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 border-red-200 dark:border-red-800' : 'bg-surface-light dark:bg-surface-dark' }}">
                                    <span class="material-symbols-outlined {{ $isLiked ? 'fill' : '' }} text-2xl">{{ $isLiked ? 'favorite' : 'favorite' }}</span>
                                    <span class="text-xs">Suka</span>
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 transition-colors flex flex-col items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-2xl">bookmark_add</span>
                                <span class="text-xs">Simpan</span>
                            </a>
                            <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 transition-colors flex flex-col items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-2xl">favorite</span>
                                <span class="text-xs">Suka</span>
                            </a>
                            @endauth

                            <button onclick="window.print()" class="w-full py-3.5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 transition-colors flex flex-col items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-2xl">print</span>
                                <span class="text-xs">Cetak</span>
                            </button>
                        </div>
                        
                        <a href="{{ route('recipes.index') }}" class="py-3.5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Toast Container -->
            <div id="toast-container" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[100] flex flex-col gap-2 pointer-events-none"></div>

            <style>
                @keyframes slide-up {
                    from { transform: translateY(100%); opacity: 0; }
                    to { transform: translateY(0); opacity: 1; }
                }
                .animate-slide-up { animation: slide-up 0.3s ease-out forwards; }
            </style>

            <script>
                function showToast(message, type = 'success') {
                    const container = document.getElementById('toast-container');
                    const toast = document.createElement('div');
                    toast.className = `px-6 py-3 rounded-full shadow-2xl backdrop-blur-md flex items-center gap-3 animate-slide-up pointer-events-auto
                        ${type === 'success' ? 'bg-black/80 text-white dark:bg-white/90 dark:text-black' : 'bg-red-500 text-white'}`;
                    
                    toast.innerHTML = `
                        <span class="material-symbols-outlined text-[20px]">${type === 'success' ? 'check_circle' : 'error'}</span>
                        <span class="text-sm font-bold">${message}</span>
                    `;
                    
                    container.appendChild(toast);
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateY(-20px)';
                        toast.style.transition = 'all 0.5s ease-in';
                        setTimeout(() => toast.remove(), 500);
                    }, 3000);
                }

                function shareRecipe(url) {
                    if (navigator.share) {
                        navigator.share({
                            title: '{{ $recipe->title }}',
                            text: 'Cek resep lezat ini di SuRasa!',
                            url: url
                        }).catch(() => {
                            copyToClipboard(url);
                        });
                    } else {
                        copyToClipboard(url);
                    }
                }

                function copyToClipboard(url) {
                    navigator.clipboard.writeText(url).then(() => {
                        showToast('Link resep berhasil disalin!');
                    }).catch(() => {
                        showToast('Gagal menyalin link.', 'error');
                    });
                }
            </script>


            <!-- Main Recipe Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Left Column: Ingredients -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <div class="bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-[2rem] p-8 lg:sticky lg:top-24">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-black text-text-main-light dark:text-text-main-dark">Bahan-bahan</h3>
                            @if($recipe->servings)
                            <span class="text-xs font-bold px-3 py-1 bg-background-light dark:bg-background-dark rounded-full text-text-sec-light dark:text-text-sec-dark border border-border-light dark:border-border-dark">{{ $recipe->servings }} Porsi</span>
                            @endif
                        </div>
                        <div class="space-y-4">
                            @if($recipe->ingredients)
                                @php
                                    $ingredients = is_array($recipe->ingredients) ? $recipe->ingredients : explode("\n", $recipe->ingredients);
                                @endphp
                                @foreach($ingredients as $ingredient)
                                    @if(trim($ingredient))
                                    <label class="flex items-start gap-4 p-3 rounded-xl hover:bg-background-light dark:hover:bg-background-dark cursor-pointer group transition-all">
                                        <div class="relative flex items-center pt-1">
                                            <input type="checkbox" class="peer size-5 rounded-md border-2 border-border-light dark:border-border-dark text-primary focus:ring-primary/20 bg-transparent checked:bg-primary checked:border-primary transition-all"/>
                                            <span class="material-symbols-outlined absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[16px] text-black opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity font-bold">check</span>
                                        </div>
                                        <span class="text-sm font-medium text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors leading-relaxed peer-checked:line-through peer-checked:text-text-sec-light dark:peer-checked:text-text-sec-dark">{{ trim($ingredient) }}</span>
                                    </label>
                                    @endif
                                @endforeach
                            @else
                            <p class="text-text-sec-light dark:text-text-sec-dark text-sm italic">Belum ada bahan yang ditambahkan.</p>
                            @endif
                        </div>

                        <!-- Nutrition Info (Optional) -->
                        @if($recipe->calories || $recipe->protein || $recipe->fat || $recipe->carbs)
                        <div class="mt-8 pt-8 border-t border-dashed border-border-light dark:border-border-dark">
                            <h4 class="font-bold text-sm mb-4 text-text-main-light dark:text-text-main-dark flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">nutrition</span>
                                Info Nutrisi
                            </h4>
                            <div class="grid grid-cols-2 gap-3">
                                @if($recipe->calories)
                                <div class="bg-background-light dark:bg-background-dark p-3 rounded-xl text-center">
                                    <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-bold uppercase">Kalori</span>
                                    <p class="font-black text-primary">{{ $recipe->calories }} kcal</p>
                                </div>
                                @endif
                                @if($recipe->protein)
                                <div class="bg-background-light dark:bg-background-dark p-3 rounded-xl text-center">
                                    <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-bold uppercase">Protein</span>
                                    <p class="font-black text-primary">{{ $recipe->protein }}g</p>
                                </div>
                                @endif
                                @if($recipe->fat)
                                <div class="bg-background-light dark:bg-background-dark p-3 rounded-xl text-center">
                                    <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-bold uppercase">Lemak</span>
                                    <p class="font-black text-primary">{{ $recipe->fat }}g</p>
                                </div>
                                @endif
                                @if($recipe->carbs)
                                <div class="bg-background-light dark:bg-background-dark p-3 rounded-xl text-center">
                                    <span class="text-xs text-text-sec-light dark:text-text-sec-dark font-bold uppercase">Karbo</span>
                                    <p class="font-black text-primary">{{ $recipe->carbs }}g</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Instructions -->
                <div class="lg:col-span-8 flex flex-col gap-10">
                    <div>
                        <h3 class="text-2xl font-black text-text-main-light dark:text-text-main-dark mb-8 flex items-center gap-3">
                            <span class="size-8 rounded-full bg-primary flex items-center justify-center text-black text-lg">
                                <span class="material-symbols-outlined text-[20px]">cooking</span>
                            </span>
                            Cara Membuat
                        </h3>

                        @if($recipe->steps)
                            @php
                                $steps = is_array($recipe->steps) ? $recipe->steps : explode("\n", $recipe->steps);
                                $stepNumber = 0;
                            @endphp
                            <div class="space-y-8">
                            @foreach($steps as $step)
                                @if(trim($step))
                                    @php $stepNumber++; @endphp
                                    <div class="flex gap-6 group">
                                        <div class="flex flex-col items-center">
                                            <div class="flex items-center justify-center size-12 rounded-2xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-black text-xl group-hover:bg-primary group-hover:border-primary group-hover:text-black transition-all shadow-sm">
                                                {{ $stepNumber }}
                                            </div>
                                            @if(!$loop->last)
                                            <div class="w-0.5 h-full bg-border-light dark:bg-border-dark my-2 group-hover:bg-primary/30 transition-colors"></div>
                                            @endif
                                        </div>
                                        <div class="flex-1 pt-2 pb-6">
                                            <p class="text-text-main-light dark:text-text-main-dark leading-relaxed text-lg font-medium">{{ trim($step) }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            </div>
                        @else
                        <p class="text-text-sec-light dark:text-text-sec-dark italic">Belum ada langkah yang ditambahkan.</p>
                        @endif
                    </div>

                    <!-- Tips Section -->
                    @if($recipe->tips)
                    <div class="p-8 bg-yellow-50 dark:bg-yellow-900/10 rounded-[2rem] border border-yellow-200 dark:border-yellow-900/30">
                        <h4 class="text-lg font-bold text-yellow-800 dark:text-yellow-200 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined">lightbulb</span>
                            Tips & Catatan Chef
                        </h4>
                        <p class="text-yellow-900/80 dark:text-yellow-100/80 leading-relaxed">{{ $recipe->tips }}</p>
                    </div>
                    @endif

                    <!-- Owner Actions -->
                    @auth
                        @if(auth()->id() === $recipe->user_id || auth()->user()->isAdmin())
                        <div class="bg-surface-light dark:bg-surface-dark p-8 rounded-[2rem] border border-border-light dark:border-border-dark flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div>
                                <h4 class="text-lg font-bold text-text-main-light dark:text-text-main-dark mb-1">Kelola Resep Ini</h4>
                                <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Anda adalah pemilik resep ini.</p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('recipes.edit', $recipe) }}" class="flex items-center gap-2 px-6 py-3 bg-text-main-light dark:bg-white text-white dark:text-black rounded-full font-bold text-sm hover:opacity-90 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit
                                </a>
                                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full font-bold text-sm hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>
        </main>
    </div>
    <!-- Cook Mode Modal -->
    <div id="cookModeModal" class="fixed inset-0 z-[100] bg-background-light dark:bg-background-dark hidden flex flex-col transition-opacity duration-300" x-data="{ showIngredients: false, timer: 0, timerRunning: false, timerInterval: null, fontSize: 1 }">
        <!-- Cook Mode Header -->
        <div class="flex flex-wrap items-center justify-between px-4 md:px-6 py-4 border-b border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark z-20 shadow-sm relative gap-4">
            <div class="flex items-center gap-4 flex-1">
                <button @click="showIngredients = !showIngredients" class="p-2 rounded-full hover:bg-background-light dark:hover:bg-background-dark transition-colors relative group shrink-0 border border-transparent hover:border-border-light dark:hover:border-border-dark" title="Lihat Bahan">
                    <span class="material-symbols-outlined text-text-main-light dark:text-text-main-dark">grocery</span>
                    <span class="absolute top-0 right-0 size-2 bg-primary rounded-full" x-show="!showIngredients"></span>
                </button>
                <div class="h-6 w-px bg-border-light dark:border-border-dark hidden sm:block"></div>
                <!-- Timer Control -->
                <div class="flex items-center gap-2 bg-background-light dark:bg-background-dark rounded-lg px-3 py-1.5 border border-border-light dark:border-border-dark shadow-inner">
                    <span class="font-mono font-bold text-lg w-16 text-center text-text-main-light dark:text-text-main-dark" x-text="new Date(timer * 1000).toISOString().substr(14, 5)">00:00</span>
                    <button @click="toggleTimer()" class="p-1 rounded hover:bg-surface-light dark:hover:bg-surface-dark text-primary-dark transition-colors">
                        <span class="material-symbols-outlined text-[24px]" x-text="timerRunning ? 'pause' : 'play_arrow'">play_arrow</span>
                    </button>
                    <button @click="resetTimer()" class="p-1 rounded hover:bg-surface-light dark:hover:bg-surface-dark text-red-500 transition-colors" title="Reset">
                        <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                    </button>
                </div>
            </div>

            <!-- Font Size Control (Hidden on very small screens) -->
            <div class="hidden sm:flex items-center gap-2 bg-background-light dark:bg-background-dark rounded-full px-3 py-1 border border-border-light dark:border-border-dark">
                <button @click="fontSize = Math.max(0.8, fontSize - 0.1)" class="text-xs font-bold px-2 hover:text-primary text-text-main-light dark:text-text-main-dark">A-</button>
                <span class="text-xs text-text-sec-light dark:text-text-sec-dark">|</span>
                <button @click="fontSize = Math.min(1.5, fontSize + 0.1)" class="text-lg font-bold px-2 hover:text-primary text-text-main-light dark:text-text-main-dark">A+</button>
            </div>

            <button onclick="closeCookMode()" class="p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 text-text-sec-light hover:text-red-500 transition-colors shrink-0">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="flex-1 flex overflow-hidden relative">
            <!-- Ingredients Sidebar (Collapsible) -->
            <div x-show="showIngredients" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="-translate-x-full opacity-0"
                 class="w-full sm:w-80 bg-surface-light dark:bg-surface-dark border-r border-border-light dark:border-border-dark overflow-y-auto p-6 shadow-xl absolute inset-y-0 left-0 z-30 lg:static lg:block lg:shadow-none"
                 style="display: none;">
                <h3 class="font-bold text-lg mb-4 text-text-main-light dark:text-text-main-dark flex items-center justify-between">
                    Daftar Bahan
                    <button @click="showIngredients = false" class="lg:hidden p-1 rounded-full hover:bg-background-light dark:hover:bg-background-dark">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </h3>
                <div class="space-y-3">
                    @if($recipe->ingredients)
                        @php $ingredients = is_array($recipe->ingredients) ? $recipe->ingredients : explode("\n", $recipe->ingredients); @endphp
                        @foreach($ingredients as $index => $ingredient)
                            @if(trim($ingredient))
                            <label class="flex items-start gap-3 p-3 rounded-xl bg-background-light dark:bg-background-dark hover:bg-gray-50 dark:hover:bg-neutral-800 cursor-pointer group transition-all text-sm border border-transparent hover:border-primary/20">
                                <input type="checkbox" class="peer mt-0.5 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"/>
                                <span class="peer-checked:line-through peer-checked:text-text-sec-light dark:peer-checked:text-text-sec-dark text-text-main-light dark:text-text-main-dark font-medium">{{ trim($ingredient) }}</span>
                            </label>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Cook Mode Main Content -->
            <div class="flex-1 flex flex-col relative bg-background-light dark:bg-background-dark w-full" @click="showIngredients = false"> <!-- Click overlay to close sidebar on mobile -->
                
                <!-- Progress Bar -->
                <div class="w-full h-2 bg-border-light dark:bg-border-dark relative z-10">
                    <div id="cookProgress" class="h-full bg-primary transition-all duration-500 ease-out shadow-[0_0_10px_rgba(249,245,6,0.5)]" style="width: 0%"></div>
                </div>

                <div class="flex-1 flex flex-col justify-center items-center p-6 md:p-12 text-center overflow-y-auto w-full relative">
                    <!-- Step Content Container -->
                    <div id="cookStepContent" class="max-w-3xl mx-auto w-full transition-all duration-300 transform origin-center" :style="`transform: scale(${fontSize})`">
                        <div class="mb-8">
                            <span class="inline-block px-6 py-2 rounded-full bg-primary/10 text-primary-dark font-black tracking-widest uppercase text-sm border border-primary/20">
                                Langkah <span id="currentStepDisplay" class="text-lg ml-1">1</span>
                            </span>
                        </div>
                        <!-- Explicit text color for visibility -->
                        <p id="stepText" class="font-black text-gray-900 dark:text-white leading-relaxed tracking-tight transition-all drop-shadow-sm text-3xl md:text-4xl"></p>
                    </div>
                </div>

                <!-- Footer Navigation -->
                <div class="p-4 md:p-6 border-t border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark flex items-center justify-center gap-4 z-20 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
                    <button onclick="prevStep()" id="btnPrev" class="px-6 md:px-8 py-4 rounded-2xl bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark font-bold text-text-sec-light dark:text-text-sec-dark hover:bg-border-light dark:hover:bg-border-dark disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center gap-2 hover:scale-105 active:scale-95">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </button>
                    
                    <div class="flex-1 max-w-md">
                        <button onclick="nextStep()" id="btnNext" class="w-full py-4 rounded-2xl bg-primary text-black font-black text-xl hover:brightness-105 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-1 active:translate-y-0 active:scale-95 transition-all flex items-center justify-center gap-2 group border-b-4 border-yellow-600 active:border-b-0">
                            Selanjutnya
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
// Recipe Data
const steps = [
    @if($recipe->steps)
        @php $steps = is_array($recipe->steps) ? $recipe->steps : explode("\n", $recipe->steps); @endphp
        @foreach($steps as $step)
            @if(trim($step))
                `{!! trim(str_replace(['`', '\\'], ['\`', '\\\\'], $step)) !!}`,
            @endif
        @endforeach
    @endif
];

let currentStepIndex = 0;
let wakeLock = null;

// Modal Elements
const modal = document.getElementById('cookModeModal');
const stepText = document.getElementById('stepText');
const currentStepDisplay = document.getElementById('currentStepDisplay');
const cookProgress = document.getElementById('cookProgress');
const btnPrev = document.getElementById('btnPrev');
const btnNext = document.getElementById('btnNext');

// Alpine Logic for Timer & UI
document.addEventListener('alpine:init', () => {
    Alpine.data('cookMode', () => ({
        // ... handled inside HTML x-data for simplicity in blade
    }))
});

// Timer Logic (Vanilla JS to work alongside Alpine x-data)
function toggleTimer() {
    // Access Alpine component data scope
    const el = document.getElementById('cookModeModal');
    const data = Alpine.$data(el);
    
    if (data.timerRunning) {
        clearInterval(data.timerInterval);
        data.timerRunning = false;
    } else {
        data.timerRunning = true;
        data.timerInterval = setInterval(() => {
            data.timer++;
        }, 1000);
    }
}

function resetTimer() {
    const el = document.getElementById('cookModeModal');
    const data = Alpine.$data(el);
    data.timerRunning = false;
    clearInterval(data.timerInterval);
    data.timer = 0;
}


function openCookMode() {
    modal.classList.remove('hidden');
    // Lock scroll on body
    document.body.style.overflow = 'hidden';
    updateStepUI();
    requestWakeLock();
}

function closeCookMode() {
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    releaseWakeLock();
}

function updateStepUI() {
    // Update Text
    stepText.innerText = steps[currentStepIndex];
    currentStepDisplay.innerText = currentStepIndex + 1;
    
    // Update Progress
    const progress = ((currentStepIndex + 1) / steps.length) * 100;
    cookProgress.style.width = `${progress}%`;

    // Button States
    btnPrev.disabled = currentStepIndex === 0;
    
    if (currentStepIndex === steps.length - 1) {
        btnNext.innerHTML = 'Selesai Masak! <span class="material-symbols-outlined">check_circle</span>';
        btnNext.classList.replace('bg-primary', 'bg-green-500');
        btnNext.classList.replace('text-black', 'text-white');
    } else {
        btnNext.innerHTML = 'Selanjutnya <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>';
        btnNext.classList.replace('bg-green-500', 'bg-primary');
        btnNext.classList.replace('text-white', 'text-black');
    }
}

function nextStep() {
    if (currentStepIndex < steps.length - 1) {
        currentStepIndex++;
        updateStepUI();
    } else {
        // Finish
        closeCookMode();
        // Optional: Show celebration confetti or ask for review
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#f9f506', '#eab308', '#ffffff']
        });
    }
}

function prevStep() {
    if (currentStepIndex > 0) {
        currentStepIndex--;
        updateStepUI();
    }
}

// Wake Lock API (Keep screen on)
async function requestWakeLock() {
    if ('wakeLock' in navigator) {
        try {
            wakeLock = await navigator.wakeLock.request('screen');
        } catch (err) {
            console.log(`${err.name}, ${err.message}`);
        }
    }
}

function releaseWakeLock() {
    if (wakeLock !== null) {
        wakeLock.release()
            .then(() => {
                wakeLock = null;
            });
    }
}

// Keyboard Navigation
document.addEventListener('keydown', function(event) {
    if (modal.classList.contains('hidden')) return;
    
    if (event.key === 'ArrowRight') nextStep();
    if (event.key === 'ArrowLeft') prevStep();
    if (event.key === 'Escape') closeCookMode();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

