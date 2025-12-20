<x-app-layout>
    <div class="bg-background-light dark:bg-background-dark min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section with Tabs -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-text-main-light dark:text-text-main-dark mb-2">
                        Area Pengguna
                    </h1>
                    <p class="text-text-sec-light dark:text-text-sec-dark text-lg">
                        Kelola karya kuliner dan koleksi pribadi Anda.
                    </p>
                </div>
                <a href="{{ route('recipes.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-full font-bold text-sm hover:border-primary transition-colors">
                    <span class="material-symbols-outlined">search</span>
                    Cari Resep Baru
                </a>
            </div>

            <!-- Profile Tabs -->
            <div class="flex items-center gap-2 mb-10 overflow-x-auto pb-2 no-scrollbar border-b border-border-light dark:border-border-dark">
                <a href="{{ route('recipes.my') }}" class="px-6 py-3 rounded-t-xl font-bold text-sm border-b-2 border-transparent text-text-sec-light dark:text-text-sec-dark hover:text-text-main-light dark:hover:text-text-main-dark hover:bg-surface-light dark:hover:bg-surface-dark transition-all whitespace-nowrap flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    Resep Saya
                </a>
                <a href="{{ route('bookmarks.index') }}" class="px-6 py-3 rounded-t-xl font-bold text-sm border-b-2 border-primary text-primary bg-primary/5 transition-all whitespace-nowrap flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">bookmark</span>
                    Disimpan
                </a>
                <a href="{{ route('profile.edit') }}" class="px-6 py-3 rounded-t-xl font-bold text-sm border-b-2 border-transparent text-text-sec-light dark:text-text-sec-dark hover:text-text-main-light dark:hover:text-text-main-dark hover:bg-surface-light dark:hover:bg-surface-dark transition-all whitespace-nowrap flex items-center gap-2 ml-auto">
                    <span class="material-symbols-outlined text-[18px]">settings</span>
                    Pengaturan
                </a>
            </div>

            <!-- Recipes Grid -->
            @if($recipes->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe->slug) }}" class="group bg-surface-light dark:bg-surface-dark rounded-2xl overflow-hidden border border-border-light dark:border-border-dark hover:border-primary hover:shadow-xl transition-all flex flex-col h-full">
                    <div class="relative aspect-[4/3] overflow-hidden shrink-0">
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
                        
                        <div class="absolute top-3 right-3 bg-white/90 dark:bg-black/70 backdrop-blur-sm p-2 rounded-full shadow-sm">
                            <span class="material-symbols-outlined text-primary fill text-[20px]">bookmark</span>
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary-dark transition-colors line-clamp-2 leading-tight">{{ $recipe->title }}</h3>
                        </div>
                        
                        <p class="text-sm text-text-sec-light dark:text-text-sec-dark mb-4 line-clamp-2">{{ $recipe->description }}</p>
                        
                        <div class="mt-auto pt-3 border-t border-border-light dark:border-border-dark flex items-center justify-between text-xs text-text-sec-light dark:text-text-sec-dark font-bold">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">timer</span>
                                {{ $recipe->cooking_time }}m
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">restaurant</span>
                                {{ $recipe->servings }}
                            </div>
                            <div class="flex items-center gap-1 text-primary-dark">
                                <span class="material-symbols-outlined text-[16px]">person</span>
                                {{ strtok($recipe->user->name, ' ') }}
                            </div>
                        </div>
                    </div>
                </a>
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
                    <span class="material-symbols-outlined text-5xl text-text-sec-light/30">bookmark_border</span>
                </div>
                <h3 class="text-2xl font-black text-text-main-light dark:text-text-main-dark mb-2">Belum Ada Koleksi</h3>
                <p class="text-text-sec-light dark:text-text-sec-dark max-w-md mb-8">
                    Anda belum menyimpan resep apapun. Jelajahi resep menarik dan simpan untuk nanti.
                </p>
                <a href="{{ route('recipes.index') }}" class="px-8 py-4 bg-primary text-black rounded-full font-bold hover:shadow-lg hover:scale-105 transition-all">
                    Jelajahi Resep
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
