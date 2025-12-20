<x-layouts.admin title="Dashboard" :header="'Dashboard'" :description="'Selamat datang di panel admin SuRasa'">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8 animate-fade-in-up delay-200">
        <!-- Total Users -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Total Users</p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-1">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">group</span>
                </div>
            </div>
        </div>

        <!-- Total Kuliner -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Total Kuliner</p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-1">{{ number_format($stats['total_kuliners']) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">restaurant</span>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Total Kategori</p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-1">{{ number_format($stats['total_categories']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">category</span>
                </div>
            </div>
        </div>

        <!-- Total Resep -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Total Resep</p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-1">{{ number_format($stats['total_recipes']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">menu_book</span>
                </div>
            </div>
        </div>

        <!-- Komentar Pending -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Komentar Pending</p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-1">{{ number_format($stats['pending_comments']) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">pending</span>
                </div>
            </div>
        </div>

        <!-- Resep Pending -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Resep Pending</p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-1">{{ number_format($stats['pending_recipes']) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">hourglass_top</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 animate-fade-in-up delay-300">
        <!-- Latest Kuliners -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 md:p-8 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">restaurant</span>
                    Kuliner Terbaru
                </h3>
                <a href="{{ route('admin.kuliners.index') }}" class="text-primary hover:text-primary-dark hover:underline text-sm font-bold transition-colors">Lihat Semua</a>
            </div>
            <div class="space-y-6">
                @forelse($latestKuliners as $kuliner)
                <div class="flex items-center gap-4 p-4 rounded-xl bg-gradient-to-r from-neutral-50 to-neutral-100/50 dark:from-neutral-800/50 dark:to-neutral-800/30 hover:from-neutral-100 hover:to-neutral-50 dark:hover:from-neutral-800 dark:hover:to-neutral-800/50 transition-all duration-300 group border border-neutral-200/50 dark:border-neutral-700/50 hover:border-primary/30 dark:hover:border-primary/30 hover:shadow-lg">
                    <div class="w-20 h-20 bg-neutral-200 dark:bg-neutral-700 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden shadow-md group-hover:shadow-xl transition-all duration-300 group-hover:scale-105 ring-2 ring-neutral-200 dark:ring-neutral-700 group-hover:ring-primary/50">
                        @if($kuliner->image)
                        <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        @php
                            $fallbackImages = ['hero_1.png', 'hero_2.png', 'hero_3.png', 'hero_4.png', 'food_bakso.png', 'food_pempek.png', 'cat_rice.png', 'cat_noodle.png', 'cat_chicken.png', 'cat_seafood.png'];
                            $seed = crc32($kuliner->id . $kuliner->name);
                            $randomImage = $fallbackImages[$seed % count($fallbackImages)];
                        @endphp
                        <img src="{{ asset('images/' . $randomImage) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-base text-neutral-900 dark:text-white truncate group-hover:text-primary transition-colors">{{ $kuliner->name }}</h4>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $kuliner->category->name ?? 'Tanpa Kategori' }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex items-center gap-1 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-lg">
                                <span class="material-symbols-outlined text-[16px] text-primary fill-current">star</span>
                                <span class="font-bold text-sm text-neutral-900 dark:text-white">{{ number_format($kuliner->average_rating, 1) }}</span>
                            </div>
                            <span class="text-xs text-neutral-400 dark:text-neutral-500">•</span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ $kuliner->location }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.kuliners.edit', $kuliner) }}" class="p-2 rounded-lg hover:bg-white dark:hover:bg-neutral-700 transition-all opacity-0 group-hover:opacity-100">
                        <span class="material-symbols-outlined text-neutral-400 hover:text-primary transition-colors">arrow_forward</span>
                    </a>
                </div>
                @empty
                <div class="text-center py-12 text-neutral-500">
                    <span class="material-symbols-outlined text-4xl mb-2 opacity-50">no_meals</span>
                    <p>Belum ada kuliner</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Latest Comments -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 md:p-8 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">reviews</span>
                    Komentar Terbaru
                </h3>
                <a href="{{ route('admin.comments.index') }}" class="text-primary hover:text-primary-dark hover:underline text-sm font-bold transition-colors">Lihat Semua</a>
            </div>
            <div class="space-y-6">
                @forelse($latestComments as $comment)
                <div class="relative pl-6 border-l-2 border-neutral-100 dark:border-neutral-800">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white dark:border-neutral-900"></div>
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-neutral-900 dark:text-white">{{ $comment->user->name }}</span>
                            <span class="text-xs font-medium text-neutral-400 bg-neutral-100 dark:bg-neutral-800 px-2 py-1 rounded-full">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-300 italic">"{{ $comment->content }}"</p>
                        <a href="{{ route('kuliners.show', $comment->kuliner->slug ?? '#') }}" class="text-xs font-medium text-primary hover:underline self-start">
                            pada {{ $comment->kuliner->name ?? 'Deleted' }}
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-neutral-500">
                    <span class="material-symbols-outlined text-4xl mb-2 opacity-50">comment</span>
                    <p>Belum ada komentar</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.admin>
