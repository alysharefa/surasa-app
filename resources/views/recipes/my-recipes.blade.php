<x-app-layout>
    <div class="bg-background-light dark:bg-background-dark min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-text-main-light dark:text-text-main-dark mb-2">
                        Area Pengguna
                    </h1>
                    <p class="text-text-sec-light dark:text-text-sec-dark text-lg">
                        Kelola karya kuliner dan koleksi pribadi Anda.
                    </p>
                </div>
                <a href="{{ route('recipes.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-black rounded-full font-bold text-sm hover:brightness-105 active:scale-95 transition-all shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">add_circle</span>
                    Tulis Resep Baru
                </a>
            </div>

            <!-- Profile Tabs -->
            <div class="flex items-center gap-2 mb-10 overflow-x-auto pb-2 no-scrollbar border-b border-border-light dark:border-border-dark">
                <a href="{{ route('recipes.my') }}" class="px-6 py-3 rounded-t-xl font-bold text-sm border-b-2 border-primary text-primary bg-primary/5 transition-all whitespace-nowrap flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    Resep Saya
                </a>
                <a href="{{ route('bookmarks.index') }}" class="px-6 py-3 rounded-t-xl font-bold text-sm border-b-2 border-transparent text-text-sec-light dark:text-text-sec-dark hover:text-text-main-light dark:hover:text-text-main-dark hover:bg-surface-light dark:hover:bg-surface-dark transition-all whitespace-nowrap flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">bookmark</span>
                    Disimpan
                </a>
                <a href="{{ route('profile.edit') }}" class="px-6 py-3 rounded-t-xl font-bold text-sm border-b-2 border-transparent text-text-sec-light dark:text-text-sec-dark hover:text-text-main-light dark:hover:text-text-main-dark hover:bg-surface-light dark:hover:bg-surface-dark transition-all whitespace-nowrap flex items-center gap-2 ml-auto">
                    <span class="material-symbols-outlined text-[18px]">settings</span>
                    Pengaturan
                </a>
            </div>

            <!-- Stats Overview -->
            @php
                $totalRecipes = $recipes->total();
                if ($totalRecipes < 3) {
                    $badgeLabel = 'Koki Pemula';
                    $badgeIcon = 'skillet';
                    $badgeColor = 'text-blue-600 dark:text-blue-400';
                    $badgeBg = 'bg-blue-100 dark:bg-blue-900/30';
                    $nextLevel = 3 - $totalRecipes;
                    $nextMsg = "$nextLevel resep lagi menuju Koki Handal";
                } elseif ($totalRecipes < 10) {
                    $badgeLabel = 'Koki Handal';
                    $badgeIcon = 'emoji_food_beverage';
                    $badgeColor = 'text-purple-600 dark:text-purple-400';
                    $badgeBg = 'bg-purple-100 dark:bg-purple-900/30';
                    $nextLevel = 10 - $totalRecipes;
                    $nextMsg = "$nextLevel resep lagi menuju Master SuRasa";
                } else {
                    $badgeLabel = 'Master SuRasa';
                    $badgeIcon = 'workspace_premium';
                    $badgeColor = 'text-orange-600 dark:text-orange-400';
                    $badgeBg = 'bg-orange-100 dark:bg-orange-900/30';
                    $nextMsg = "Luar biasa! Anda adalah legenda kuliner.";
                }
            @endphp

            @if($recipes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
                <!-- Gamification Badge -->
                <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl {{ $badgeColor }}">{{ $badgeIcon }}</span>
                    </div>
                    <div class="size-10 rounded-full {{ $badgeBg }} flex items-center justify-center {{ $badgeColor }} mb-4 relative z-10">
                        <span class="material-symbols-outlined">{{ $badgeIcon }}</span>
                    </div>
                    <p class="text-xl font-black text-text-main-light dark:text-text-main-dark leading-tight mb-1">{{ $badgeLabel }}</p>
                    <p class="text-xs font-bold text-text-sec-light dark:text-text-sec-dark">{{ $nextMsg }}</p>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm">
                    <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center text-primary mb-4">
                        <span class="material-symbols-outlined">menu_book</span>
                    </div>
                    <p class="text-3xl font-black text-text-main-light dark:text-text-main-dark">{{ $recipes->total() }}</p>
                    <p class="text-sm font-bold text-text-sec-light dark:text-text-sec-dark">Total Resep</p>
                </div>
                <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm">
                    <div class="size-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <p class="text-3xl font-black text-text-main-light dark:text-text-main-dark">{{ $recipes->where('is_approved', true)->count() }}</p>
                    <p class="text-sm font-bold text-text-sec-light dark:text-text-sec-dark">Dipublikasi</p>
                </div>
                <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm">
                    <div class="size-10 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-400 mb-4">
                        <span class="material-symbols-outlined">pending</span>
                    </div>
                    <p class="text-3xl font-black text-text-main-light dark:text-text-main-dark">{{ $recipes->where('is_approved', false)->count() }}</p>
                    <p class="text-sm font-bold text-text-sec-light dark:text-text-sec-dark">Menunggu Review</p>
                </div>
                <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm">
                    <div class="size-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4">
                        <span class="material-symbols-outlined">visibility</span>
                    </div>
                    <p class="text-3xl font-black text-text-main-light dark:text-text-main-dark">{{ $recipes->sum('views') }}</p>
                    <p class="text-sm font-bold text-text-sec-light dark:text-text-sec-dark">Total Views</p>
                </div>
            </div>

            <!-- Recipe List -->
            <div class="flex flex-col gap-4">
                @foreach($recipes as $recipe)
                <div class="group bg-surface-light dark:bg-surface-dark p-4 rounded-[2rem] border border-border-light dark:border-border-dark hover:border-primary/50 transition-colors flex flex-col sm:flex-row gap-6 items-center">
                    <!-- Image -->
                    <div class="w-full sm:w-48 aspect-[4/3] rounded-2xl overflow-hidden shrink-0">
                        @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-primary/60">menu_book</span>
                        </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1 w-full text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-2">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $recipe->is_approved ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                {{ $recipe->is_approved ? 'Public' : 'Pending Review' }}
                            </span>
                            <span class="text-xs font-bold text-text-sec-light dark:text-text-sec-dark">•</span>
                            <span class="text-xs font-bold text-text-sec-light dark:text-text-sec-dark">{{ $recipe->created_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-xl font-black text-text-main-light dark:text-text-main-dark mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                            <a href="{{ route('recipes.show', $recipe->slug) }}">{{ $recipe->title }}</a>
                        </h3>
                        <p class="text-text-sec-light dark:text-text-sec-dark text-sm line-clamp-2 mb-4 max-w-2xl">
                            {{ $recipe->description }}
                        </p>
                        
                        <div class="flex items-center justify-center sm:justify-start gap-6 text-sm font-bold text-text-sec-light dark:text-text-sec-dark">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                {{ $recipe->views }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">timer</span>
                                {{ $recipe->cooking_time }}m
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">restaurant</span>
                                {{ $recipe->servings }} Porsi
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex sm:flex-col gap-2 shrink-0">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="p-3 rounded-xl bg-background-light dark:bg-background-dark text-text-main-light dark:text-text-main-dark hover:bg-primary hover:text-black transition-colors" title="Edit Resep">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Hapus resep ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-3 rounded-xl bg-red-50 dark:bg-red-900/10 text-red-500 hover:bg-red-500 hover:text-white transition-colors" title="Hapus Resep">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $recipes->links() }}
            </div>

            @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 bg-surface-light dark:bg-surface-dark rounded-[2rem] border border-border-light dark:border-border-dark text-center">
                <div class="size-24 bg-background-light dark:bg-background-dark rounded-full flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-5xl text-text-sec-light/30">post_add</span>
                </div>
                <h3 class="text-2xl font-black text-text-main-light dark:text-text-main-dark mb-2">Belum Ada Resep</h3>
                <p class="text-text-sec-light dark:text-text-sec-dark max-w-md mb-8">
                    Anda belum menulis resep apapun. Mulailah berbagi keahlian memasak Anda sekarang!
                </p>
                <a href="{{ route('recipes.create') }}" class="px-8 py-4 bg-primary text-black rounded-full font-bold hover:shadow-lg hover:scale-105 transition-all">
                    Tulis Resep Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
