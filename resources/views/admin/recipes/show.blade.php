<x-layouts.admin 
    title="{{ $recipe->title }}" 
    :header="'Detail Resep'" 
    :breadcrumbs="[['label' => 'Resep', 'route' => 'admin.recipes.index'], ['label' => $recipe->title]]"
>
    <!-- Content from resources/views/recipes/show.blade.php, adapted for Admin -->
    <div class="bg-background-light dark:bg-background-dark min-h-screen py-8">
        <main class="w-full max-w-[1280px] mx-auto px-4 md:px-6 lg:px-8">
            
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
                            MULAI MASAK (ADMIN MODE)
                        </button>

                        <div class="grid grid-cols-3 gap-2">
                            <!-- Auth Checks Removed for Admin View - Always Show or Adapt -->
                            <!-- Likes/Bookmarks point to public routes -->
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

                            <button onclick="window.print()" class="w-full py-3.5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 transition-colors flex flex-col items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-2xl">print</span>
                                <span class="text-xs">Cetak</span>
                            </button>
                        </div>
                        
                        <a href="{{ route('admin.recipes.index') }}" class="py-3.5 rounded-xl bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark font-bold hover:bg-background-light dark:hover:bg-neutral-800 transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Kembali ke Daftar
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
                    <div class="bg-surface-light dark:bg-surface-dark p-8 rounded-[2rem] border border-border-light dark:border-border-dark flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div>
                            <h4 class="text-lg font-bold text-text-main-light dark:text-text-main-dark mb-1">Aksi Admin</h4>
                            <p class="text-sm text-text-sec-light dark:text-text-sec-dark">Kelola resep ini sebagai administrator.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @if(!$recipe->is_approved)
                            <form action="{{ route('admin.recipes.approve', $recipe) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-green-500 text-white rounded-full font-bold text-sm hover:bg-green-600 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    Setujui
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.recipes.reject', $recipe) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-yellow-500 text-black rounded-full font-bold text-sm hover:bg-yellow-600 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">unpublished</span>
                                    Batalkan Persetujuan
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full font-bold text-sm hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Cook Mode Modal -->
    <div id="cookModeModal" class="fixed inset-0 z-[9999] bg-background-light dark:bg-background-dark hidden flex-col transition-opacity duration-300" 
         x-data="cookModeData()" 
         x-init="initCookMode()">
        
        <!-- Timer Alarm Audio -->
        <audio id="timerAlarm" preload="auto">
            <source src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2teleVwo0LPVyWs+CRF+qdLVgEs0IFmbtLlwUjMYTIuqronrpJOKh4aJkJeXko6HgH6EjZWVjYV+fYKLlZaNhH5+g4yVlY2EfoCDjJWVjYSAgoOMlZWNhIKDhI2VlY2EgoSFjZWVjYWEhYaOlZWNhYWGh46VlY2FhoaIjpWVjYeHh4mPlZWNiIiIio+VlY2JiYmLkJWVjYqKioyQlZWNi4uLjZGVlY2MjIyOkpWVjY2NjY+S" type="audio/wav">
        </audio>

        <!-- Cook Mode Header -->
        <div class="flex flex-wrap items-center justify-between px-4 md:px-6 py-3 border-b border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark z-20 shadow-sm relative gap-3">
            <div class="flex items-center gap-2 sm:gap-3 flex-1 flex-wrap">
                <!-- Ingredients Toggle -->
                <button @click="showIngredients = !showIngredients" class="p-2 rounded-xl hover:bg-background-light dark:hover:bg-background-dark transition-colors relative shrink-0 border border-border-light dark:border-border-dark" title="Lihat Bahan">
                    <span class="material-symbols-outlined text-text-main-light dark:text-text-main-dark">grocery</span>
                    <span class="absolute -top-1 -right-1 size-2 bg-primary rounded-full animate-pulse" x-show="!showIngredients"></span>
                </button>

                <!-- TTS Toggle -->
                <button @click="toggleTTS()" class="p-2 rounded-xl transition-colors shrink-0 border" 
                        :class="ttsEnabled ? 'bg-primary/20 border-primary text-primary' : 'border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark text-text-main-light dark:text-text-main-dark'" 
                        title="Baca Langkah (Text-to-Speech)">
                    <span class="material-symbols-outlined" x-text="ttsEnabled ? 'volume_up' : 'volume_off'">volume_off</span>
                </button>

                <!-- Voice Control Toggle -->
                <button @click="toggleVoiceControl()" class="p-2 rounded-xl transition-colors shrink-0 border" 
                        :class="voiceEnabled ? 'bg-red-500/20 border-red-500 text-red-500 animate-pulse' : 'border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark text-text-main-light dark:text-text-main-dark'"
                        title="Kontrol Suara (Voice Control)">
                    <span class="material-symbols-outlined" x-text="voiceEnabled ? 'mic' : 'mic_off'">mic_off</span>
                </button>

                <div class="h-6 w-px bg-border-light dark:bg-border-dark hidden sm:block"></div>

                <!-- Countdown Timer with Presets -->
                <div class="flex items-center gap-1 sm:gap-2 bg-background-light dark:bg-background-dark rounded-xl px-2 sm:px-3 py-1.5 border border-border-light dark:border-border-dark shadow-inner">
                    <span class="font-mono font-bold text-base sm:text-lg w-14 sm:w-16 text-center" 
                          :class="countdownTimer > 0 && countdownTimer <= 10 ? 'text-red-500 animate-pulse' : 'text-text-main-light dark:text-text-main-dark'"
                          x-text="formatTime(countdownTimer)">00:00</span>
                    <button @click="toggleCountdown()" class="p-1 rounded hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" :class="countdownRunning ? 'text-red-500' : 'text-primary'">
                        <span class="material-symbols-outlined text-[20px] sm:text-[24px]" x-text="countdownRunning ? 'pause' : 'play_arrow'">play_arrow</span>
                    </button>
                    <button @click="resetCountdown()" class="p-1 rounded hover:bg-surface-light dark:hover:bg-surface-dark text-text-sec-light dark:text-text-sec-dark transition-colors" title="Reset">
                        <span class="material-symbols-outlined text-[18px] sm:text-[20px]">restart_alt</span>
                    </button>
                </div>

                <!-- Timer Presets -->
                <div class="hidden sm:flex items-center gap-1">
                    <template x-for="preset in timerPresets" :key="preset">
                        <button @click="addTime(preset)" class="px-2 py-1 text-xs font-bold rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark hover:bg-primary hover:text-black hover:border-primary transition-all text-text-main-light dark:text-text-main-dark" x-text="'+' + preset + 'm'"></button>
                    </template>
                </div>
            </div>

            <!-- Right Side Controls -->
            <div class="flex items-center gap-2">
                <!-- Font Size Control -->
                <div class="hidden md:flex items-center gap-1 bg-background-light dark:bg-background-dark rounded-xl px-2 py-1 border border-border-light dark:border-border-dark">
                    <button @click="fontSize = Math.max(0.8, fontSize - 0.1)" class="text-xs font-bold px-1.5 hover:text-primary text-text-main-light dark:text-text-main-dark">A-</button>
                    <span class="text-xs text-text-sec-light dark:text-text-sec-dark">|</span>
                    <button @click="fontSize = Math.min(1.5, fontSize + 0.1)" class="text-base font-bold px-1.5 hover:text-primary text-text-main-light dark:text-text-main-dark">A+</button>
                </div>

                <button @click="closeCookMode()" class="p-2 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 text-text-sec-light hover:text-red-500 transition-colors shrink-0 border border-transparent hover:border-red-200 dark:hover:border-red-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

        <div class="flex-1 flex overflow-hidden relative">
            <!-- Ingredients Sidebar with Serving Adjuster -->
            <div x-show="showIngredients" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="-translate-x-full opacity-0"
                 class="w-full sm:w-80 bg-surface-light dark:bg-surface-dark border-r border-border-light dark:border-border-dark overflow-y-auto p-5 shadow-xl absolute inset-y-0 left-0 z-30 lg:static lg:block lg:shadow-none"
                 style="display: none;"
                 @click.stop>
                
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg text-text-main-light dark:text-text-main-dark">Daftar Bahan</h3>
                    <button @click="showIngredients = false" class="lg:hidden p-1.5 rounded-full hover:bg-background-light dark:hover:bg-background-dark border border-border-light dark:border-border-dark">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <!-- Serving Size Adjuster -->
                <div class="mb-4 p-3 rounded-xl bg-primary/10 border border-primary/20">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-text-main-light dark:text-text-main-dark">Porsi</span>
                        <div class="flex items-center gap-2">
                            <button @click="servingMultiplier = Math.max(0.5, servingMultiplier - 0.5)" class="size-8 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark flex items-center justify-center hover:bg-primary hover:text-black hover:border-primary transition-all">
                                <span class="material-symbols-outlined text-[18px]">remove</span>
                            </button>
                            <span class="w-12 text-center font-black text-primary text-lg" x-text="servingMultiplier + 'x'">1x</span>
                            <button @click="servingMultiplier = Math.min(4, servingMultiplier + 0.5)" class="size-8 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark flex items-center justify-center hover:bg-primary hover:text-black hover:border-primary transition-all">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                            </button>
                        </div>
                    </div>
                    <p class="text-xs text-text-sec-light dark:text-text-sec-dark mt-1" x-show="servingMultiplier !== 1">Jumlah bahan disesuaikan</p>
                </div>

                <div class="space-y-2">
                    @if($recipe->ingredients)
                        @php $ingredients = is_array($recipe->ingredients) ? $recipe->ingredients : explode("\n", $recipe->ingredients); @endphp
                        @foreach($ingredients as $index => $ingredient)
                            @if(trim($ingredient))
                            <label class="flex items-start gap-3 p-2.5 rounded-xl bg-background-light dark:bg-background-dark hover:bg-gray-50 dark:hover:bg-neutral-800 cursor-pointer group transition-all text-sm border border-transparent hover:border-primary/20">
                                <input type="checkbox" class="peer mt-0.5 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"/>
                                <span class="peer-checked:line-through peer-checked:text-text-sec-light dark:peer-checked:text-text-sec-dark text-text-main-light dark:text-text-main-dark font-medium leading-snug">{{ trim($ingredient) }}</span>
                            </label>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Cook Mode Main Content -->
            <div class="flex-1 flex flex-col relative bg-background-light dark:bg-background-dark w-full" @click="showIngredients = false">
                
                <!-- Progress Bar with Step Dots -->
                <div class="relative z-10">
                    <div class="w-full h-1.5 bg-border-light dark:bg-border-dark">
                        <div class="h-full bg-primary transition-all duration-500 ease-out shadow-[0_0_10px_rgba(249,245,6,0.5)]" :style="`width: ${((currentStep + 1) / totalSteps) * 100}%`"></div>
                    </div>
                    
                    <!-- Step Dots Navigation -->
                    <div class="flex justify-center gap-2 py-3 px-4 bg-surface-light/50 dark:bg-surface-dark/50 backdrop-blur-sm border-b border-border-light dark:border-border-dark">
                        <template x-for="(_, index) in Array.from({length: totalSteps})" :key="index">
                            <button @click="goToStep(index)" 
                                    class="relative group transition-all duration-300"
                                    :class="index === currentStep ? 'scale-125' : 'hover:scale-110'">
                                <div class="size-3 rounded-full transition-all duration-300 border-2"
                                     :class="{
                                         'bg-primary border-primary shadow-lg shadow-primary/50': index === currentStep,
                                         'bg-green-500 border-green-500': completedSteps.includes(index) && index !== currentStep,
                                         'bg-background-light dark:bg-background-dark border-border-light dark:border-border-dark hover:border-primary/50': !completedSteps.includes(index) && index !== currentStep
                                     }">
                                </div>
                                <span class="absolute -bottom-5 left-1/2 -translate-x-1/2 text-[10px] font-bold opacity-0 group-hover:opacity-100 transition-opacity text-text-sec-light dark:text-text-sec-dark" x-text="index + 1"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Step Content Area -->
                <div class="flex-1 flex flex-col justify-center items-center p-6 md:p-12 text-center overflow-y-auto w-full relative">
                    <!-- Mobile Timer Presets -->
                    <div class="sm:hidden flex items-center justify-center gap-2 mb-6">
                        <template x-for="preset in timerPresets" :key="preset">
                            <button @click="addTime(preset)" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark hover:bg-primary hover:text-black hover:border-primary transition-all text-text-main-light dark:text-text-main-dark" x-text="'+' + preset + 'm'"></button>
                        </template>
                    </div>

                    <!-- Step Content Container -->
                    <div class="max-w-3xl mx-auto w-full transition-all duration-300 transform origin-center" :style="`transform: scale(${fontSize})`">
                        <div class="mb-6">
                            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-primary/10 text-primary-dark font-black tracking-widest uppercase text-sm border border-primary/20">
                                <span class="material-symbols-outlined text-[18px]" x-show="completedSteps.includes(currentStep)">check_circle</span>
                                Langkah <span class="text-lg ml-1" x-text="currentStep + 1">1</span>
                                <span class="text-xs opacity-60">/ <span x-text="totalSteps"></span></span>
                            </span>
                        </div>
                        <p class="font-black text-gray-900 dark:text-white leading-relaxed tracking-tight transition-all drop-shadow-sm text-2xl sm:text-3xl md:text-4xl" x-text="steps[currentStep]"></p>
                        
                        <!-- Mark as Complete Button -->
                        <button @click="toggleStepComplete(currentStep)" 
                                class="mt-8 px-6 py-2 rounded-full text-sm font-bold transition-all border"
                                :class="completedSteps.includes(currentStep) 
                                    ? 'bg-green-500/20 border-green-500 text-green-600 dark:text-green-400' 
                                    : 'bg-background-light dark:bg-background-dark border-border-light dark:border-border-dark text-text-sec-light dark:text-text-sec-dark hover:border-green-500 hover:text-green-500'">
                            <span class="material-symbols-outlined text-[16px] align-middle mr-1" x-text="completedSteps.includes(currentStep) ? 'check_circle' : 'radio_button_unchecked'"></span>
                            <span x-text="completedSteps.includes(currentStep) ? 'Selesai ✓' : 'Tandai Selesai'"></span>
                        </button>
                    </div>
                </div>

                <!-- Timer Alert Overlay -->
                <div x-show="timerAlert" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute inset-0 bg-red-500/90 flex flex-col items-center justify-center z-40 backdrop-blur-sm"
                     @click="dismissAlert()">
                    <span class="material-symbols-outlined text-white text-8xl animate-bounce">timer</span>
                    <p class="text-white text-3xl font-black mt-4">Waktu Habis!</p>
                    <p class="text-white/80 text-lg mt-2">Ketuk untuk menutup</p>
                </div>

                <!-- Footer Navigation -->
                <div class="p-4 md:p-5 border-t border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark flex items-center justify-center gap-3 z-20 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                    <button @click="prevStep()" 
                            class="px-5 md:px-6 py-3.5 rounded-2xl bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark font-bold text-text-sec-light dark:text-text-sec-dark hover:bg-border-light dark:hover:bg-border-dark disabled:opacity-40 disabled:cursor-not-allowed transition-all flex items-center gap-2 hover:scale-105 active:scale-95"
                            :disabled="currentStep === 0">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </button>
                    
                    <div class="flex-1 max-w-sm">
                        <button @click="nextStep()" 
                                class="w-full py-3.5 rounded-2xl font-black text-lg hover:brightness-105 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all flex items-center justify-center gap-2 group border-b-4 active:border-b-0"
                                :class="currentStep === totalSteps - 1 
                                    ? 'bg-green-500 text-white border-green-700 hover:shadow-green-500/30' 
                                    : 'bg-primary text-black border-yellow-600 hover:shadow-primary/30'">
                            <span x-text="currentStep === totalSteps - 1 ? 'Selesai Masak!' : 'Selanjutnya'"></span>
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform" x-text="currentStep === totalSteps - 1 ? 'celebration' : 'arrow_forward'">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Recipe Data - with robust null handling
    const recipeStepsRaw = @json($recipe->steps);
    console.log('Raw steps from server:', recipeStepsRaw, 'Type:', typeof recipeStepsRaw);

    let steps = [];
    if (recipeStepsRaw) {
        if (Array.isArray(recipeStepsRaw)) {
            steps = recipeStepsRaw.filter(step => step && String(step).trim() !== '');
        } else if (typeof recipeStepsRaw === 'string') {
            steps = recipeStepsRaw.split('\n').filter(step => step && step.trim() !== '');
        } else if (typeof recipeStepsRaw === 'object') {
            // Handle case where steps might be an object with numeric keys
            steps = Object.values(recipeStepsRaw).filter(step => step && String(step).trim() !== '');
        }
    }
    console.log('Processed steps array:', steps, 'Length:', steps.length);

    // Alpine.js Cook Mode Data
    function cookModeData() {
        return {
            // State
            showIngredients: false,
            fontSize: 1,
            currentStep: 0,
            totalSteps: steps.length,
            steps: steps,
            completedSteps: [],
            
            // Timer State
            countdownTimer: 0,
            countdownRunning: false,
            countdownInterval: null,
            timerPresets: [1, 5, 10, 30],
            timerAlert: false,
            
            // TTS State
            ttsEnabled: false,
            speechSynth: null,
            
            // Voice Control State
            voiceEnabled: false,
            recognition: null,
            
            // Serving Adjuster
            servingMultiplier: 1,
            
            // Wake Lock
            wakeLock: null,

            // Initialize
            initCookMode() {
                this.speechSynth = window.speechSynthesis;
                this.initVoiceRecognition();
            },

            // Format time display
            formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            },

            // Countdown Timer Functions
            addTime(minutes) {
                this.countdownTimer += minutes * 60;
            },

            toggleCountdown() {
                if (this.countdownRunning) {
                    clearInterval(this.countdownInterval);
                    this.countdownRunning = false;
                } else if (this.countdownTimer > 0) {
                    this.countdownRunning = true;
                    this.countdownInterval = setInterval(() => {
                        if (this.countdownTimer > 0) {
                            this.countdownTimer--;
                            if (this.countdownTimer === 0) {
                                this.triggerAlarm();
                            }
                        }
                    }, 1000);
                }
            },

            resetCountdown() {
                this.countdownRunning = false;
                clearInterval(this.countdownInterval);
                this.countdownTimer = 0;
                this.timerAlert = false;
            },

            triggerAlarm() {
                this.countdownRunning = false;
                clearInterval(this.countdownInterval);
                this.timerAlert = true;
                
                // Play alarm sound
                const alarm = document.getElementById('timerAlarm');
                if (alarm) {
                    alarm.currentTime = 0;
                    alarm.play().catch(() => {});
                }

                // Browser notification
                if ('Notification' in window && Notification.permission === 'granted') {
                    new Notification('⏰ Timer Selesai!', {
                        body: 'Waktu memasak sudah habis!',
                        icon: '/favicon.ico'
                    });
                }

                // Vibrate if supported
                if ('vibrate' in navigator) {
                    navigator.vibrate([200, 100, 200, 100, 200]);
                }
            },

            dismissAlert() {
                this.timerAlert = false;
            },

            // TTS Functions
            toggleTTS() {
                this.ttsEnabled = !this.ttsEnabled;
                if (this.ttsEnabled) {
                    this.speakStep();
                    // Request notification permission for timer
                    if ('Notification' in window && Notification.permission === 'default') {
                        Notification.requestPermission();
                    }
                } else {
                    this.speechSynth?.cancel();
                }
            },

            speakStep() {
                if (!this.ttsEnabled || !this.speechSynth) return;
                
                this.speechSynth.cancel();
                const utterance = new SpeechSynthesisUtterance(this.steps[this.currentStep]);
                utterance.lang = 'id-ID';
                utterance.rate = 0.9;
                this.speechSynth.speak(utterance);
            },

            // Voice Control Functions
            initVoiceRecognition() {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                if (!SpeechRecognition) return;

                this.recognition = new SpeechRecognition();
                this.recognition.continuous = true;
                this.recognition.interimResults = false;
                this.recognition.lang = 'id-ID';

                this.recognition.onresult = (event) => {
                    const last = event.results.length - 1;
                    const command = event.results[last][0].transcript.toLowerCase().trim();
                    console.log('Voice command:', command);
                    this.handleVoiceCommand(command);
                };

                this.recognition.onerror = (event) => {
                    console.log('Voice recognition error:', event.error);
                    if (event.error === 'not-allowed') {
                        this.voiceEnabled = false;
                    }
                };

                this.recognition.onend = () => {
                    if (this.voiceEnabled) {
                        this.recognition.start();
                    }
                };
            },

            handleVoiceCommand(command) {
                if (command.includes('next') || command.includes('selanjutnya') || command.includes('lanjut')) {
                    this.nextStep();
                } else if (command.includes('previous') || command.includes('sebelumnya') || command.includes('kembali')) {
                    this.prevStep();
                } else if (command.includes('repeat') || command.includes('ulangi') || command.includes('ulang')) {
                    this.speakStep();
                } else if (command.includes('selesai') || command.includes('done') || command.includes('complete')) {
                    this.toggleStepComplete(this.currentStep);
                }
            },

            toggleVoiceControl() {
                if (!this.recognition) {
                    alert('Browser tidak mendukung Voice Control');
                    return;
                }

                this.voiceEnabled = !this.voiceEnabled;
                if (this.voiceEnabled) {
                    this.recognition.start();
                } else {
                    this.recognition.stop();
                }
            },

            // Step Navigation
            nextStep() {
                if (this.currentStep < this.totalSteps - 1) {
                    this.currentStep++;
                    this.speakStep();
                } else {
                    this.closeCookMode();
                    // Confetti celebration
                    if (typeof confetti !== 'undefined') {
                        confetti({
                            particleCount: 150,
                            spread: 70,
                            origin: { y: 0.6 },
                            colors: ['#f9f506', '#eab308', '#22c55e', '#ffffff']
                        });
                    }
                }
            },

            prevStep() {
                if (this.currentStep > 0) {
                    this.currentStep--;
                    this.speakStep();
                }
            },

            goToStep(index) {
                this.currentStep = index;
                this.speakStep();
            },

            toggleStepComplete(index) {
                const idx = this.completedSteps.indexOf(index);
                if (idx > -1) {
                    this.completedSteps.splice(idx, 1);
                } else {
                    this.completedSteps.push(index);
                }
            },

            // Modal Controls
            async openCookMode() {
                document.getElementById('cookModeModal').classList.remove('hidden');
                document.getElementById('cookModeModal').classList.add('flex');
                document.body.style.overflow = 'hidden';
                // Hide admin sidebar and navbar to prevent z-index issues
                document.querySelector('aside')?.classList.add('!hidden');
                document.querySelector('header')?.classList.add('!hidden');
                await this.requestWakeLock();
            },

            closeCookMode() {
                document.getElementById('cookModeModal').classList.add('hidden');
                document.getElementById('cookModeModal').classList.remove('flex');
                document.body.style.overflow = '';
                // Show admin sidebar and navbar again
                document.querySelector('aside')?.classList.remove('!hidden');
                document.querySelector('header')?.classList.remove('!hidden');
                this.releaseWakeLock();
                this.speechSynth?.cancel();
                if (this.voiceEnabled) {
                    this.recognition?.stop();
                    this.voiceEnabled = false;
                }
                clearInterval(this.countdownInterval);
            },

            // Wake Lock
            async requestWakeLock() {
                if ('wakeLock' in navigator) {
                    try {
                        this.wakeLock = await navigator.wakeLock.request('screen');
                    } catch (err) {
                        console.log('Wake Lock error:', err);
                    }
                }
            },

            releaseWakeLock() {
                if (this.wakeLock) {
                    this.wakeLock.release();
                    this.wakeLock = null;
                }
            }
        }
    }

    // Global function to open cook mode (called from button outside Alpine scope)
    function openCookMode() {
        const modal = document.getElementById('cookModeModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        // Hide admin sidebar and navbar immediately
        document.querySelector('aside')?.classList.add('!hidden');
        document.querySelector('header')?.classList.add('!hidden');
        
        // Trigger Alpine's init
        const data = Alpine.$data(modal);
        if (data) {
            data.openCookMode();
        }
    }

    function closeCookMode() {
        const modal = document.getElementById('cookModeModal');
        const data = Alpine.$data(modal);
        if (data) {
            data.closeCookMode();
        }
    }

    // Keyboard Navigation
    document.addEventListener('keydown', function(event) {
        const modal = document.getElementById('cookModeModal');
        if (modal.classList.contains('hidden')) return;
        
        const data = Alpine.$data(modal);
        if (!data) return;
        
        if (event.key === 'ArrowRight') data.nextStep();
        if (event.key === 'ArrowLeft') data.prevStep();
        if (event.key === 'Escape') data.closeCookMode();
        if (event.key === ' ') {
            event.preventDefault();
            data.toggleStepComplete(data.currentStep);
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</x-layouts.admin>
