<x-layouts.admin 
    title="Daftar Kuliner" 
    :header="'Kelola Kuliner'" 
    :description="'Lihat dan kelola semua data kuliner'"
    :breadcrumbs="[['label' => 'Kuliner']]"
>
    <!-- Actions & Filters -->
    <div class="relative z-20 bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 mb-8 animate-fade-in-up delay-200">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Search & Filter -->
            <form action="{{ route('admin.kuliners.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 flex-1 w-full md:w-auto">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari kuliner..." 
                           class="w-full h-12 pl-12 pr-5 rounded-lg bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white placeholder:text-neutral-400">
                </div>
                <div class="relative min-w-[200px]" x-data="{ open: false }">
                    <!-- Hidden Input -->
                    <input type="hidden" name="category" x-ref="categoryInput" value="{{ request('category') }}">

                    <!-- Trigger Button -->
                    <button type="button" 
                            @click="open = !open" 
                            @click.away="open = false" 
                            class="w-full h-12 pl-12 pr-10 flex items-center text-left rounded-lg bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none text-neutral-900 dark:text-white cursor-pointer hover:border-primary transition-colors group">
                        <span class="material-symbols-outlined absolute left-4 text-neutral-400 group-hover:text-primary transition-colors">filter_list</span>
                        <span class="line-clamp-1 block flex-1 text-sm font-medium">
                            @if(request('category'))
                                {{ $categories->firstWhere('id', request('category'))->name ?? 'Semua Kategori' }}
                            @else
                                Semua Kategori
                            @endif
                        </span>
                        <span class="material-symbols-outlined absolute right-4 text-neutral-400 transition-transform duration-200 group-hover:text-primary" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="absolute z-50 w-full mt-2 bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl shadow-neutral-200/50 dark:shadow-none border border-neutral-100 dark:border-neutral-800 max-h-64 overflow-y-auto custom-scrollbar">
                        
                        <div class="p-1.5 space-y-0.5">
                            <button type="button" 
                                    @click="$refs.categoryInput.value = ''; $el.closest('form').submit()"
                                    class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm font-medium flex items-center justify-between group
                                    {{ !request('category') ? 'bg-primary/10 text-primary dark:text-primary' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-white' }}">
                                <span>Semua Kategori</span>
                                @if(!request('category'))
                                <span class="material-symbols-outlined text-[18px]">check</span>
                                @endif
                            </button>

                            @foreach($categories as $category)
                            <button type="button" 
                                    @click="$refs.categoryInput.value = '{{ $category->id }}'; $el.closest('form').submit()"
                                    class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm font-medium flex items-center justify-between group
                                    {{ request('category') == $category->id ? 'bg-primary/10 text-primary dark:text-primary' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-white' }}">
                                <span>{{ $category->name }}</span>
                                @if(request('category') == $category->id)
                                <span class="material-symbols-outlined text-[18px]">check</span>
                                @endif
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>

            <!-- Add Button -->
            <a href="{{ route('admin.kuliners.create') }}" class="h-12 px-6 rounded-lg bg-primary text-neutral-900 font-bold hover:bg-primary-dark shadow-lg shadow-yellow-200/50 dark:shadow-none transition-all flex items-center gap-2 whitespace-nowrap shrink-0">
                <span class="material-symbols-outlined">add</span>
                Tambah Kuliner
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl shadow-neutral-100/50 dark:shadow-none border border-neutral-100 dark:border-neutral-800 overflow-hidden animate-fade-in-up delay-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50 border-b border-neutral-100 dark:border-neutral-800">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kuliner</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-right text-xs font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @forelse($kuliners as $kuliner)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-xl bg-neutral-100 dark:bg-neutral-800 overflow-hidden flex-shrink-0 shadow-md border-2 border-neutral-200 dark:border-neutral-700 group-hover:border-primary/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl">
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
                                    <p class="font-bold text-neutral-900 dark:text-white text-base group-hover:text-primary transition-colors truncate">{{ $kuliner->name }}</p>
                                    <p class="text-sm text-neutral-500 mt-1 line-clamp-2">{{ Str::limit($kuliner->description, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-700 whitespace-nowrap">
                                {{ $kuliner->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ $kuliner->location }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-1.5 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10 px-3 py-1.5 rounded-lg w-fit shadow-sm border border-yellow-200/50 dark:border-yellow-800/50">
                                <span class="material-symbols-outlined text-[18px] text-primary fill-current">star</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($kuliner->average_rating, 1) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($kuliner->is_active)
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 flex items-center gap-1.5 w-fit shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse shadow-sm shadow-green-500/50"></span>
                                Aktif
                            </span>
                            @else
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/20 dark:to-rose-900/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800 flex items-center gap-1.5 w-fit shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Nonaktif
                            </span>
                            @endif
                            @if($kuliner->is_featured)
                            <div class="mt-2 px-3 py-1 rounded-lg text-[10px] font-bold bg-gradient-to-r from-primary/20 to-yellow-200/20 text-neutral-900 dark:text-primary w-fit uppercase tracking-wider shadow-sm border border-primary/30">Featured</div>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-2 text-neutral-400">
                                <a href="{{ route('admin.kuliners.edit', $kuliner) }}" class="p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors hover:text-primary">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.kuliners.destroy', $kuliner) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors hover:text-red-500">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-neutral-500">
                            <span class="material-symbols-outlined text-5xl mb-4 text-neutral-300">no_meals</span>
                            <p class="text-lg font-medium">Belum ada data kuliner</p>
                            <a href="{{ route('admin.kuliners.create') }}" class="mt-4 inline-block text-primary hover:underline font-medium">Tambah Kuliner Baru</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($kuliners->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-800/50">
            {{ $kuliners->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
