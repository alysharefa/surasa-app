<x-layouts.admin 
    title="Kategori" 
    :header="'Kelola Kategori'" 
    :description="'Lihat dan kelola semua kategori kuliner'"
    :breadcrumbs="[['label' => 'Kategori']]"
>
    <!-- Actions & Filter -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 mb-8 animate-fade-in-up delay-200">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Search -->
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex-1 w-full md:w-auto">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari kategori..." 
                           class="w-full h-12 pl-12 pr-5 rounded-lg bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white placeholder:text-neutral-400">
                </div>
            </form>

            <!-- Add Button -->
            <a href="{{ route('admin.categories.create') }}" class="h-12 px-6 rounded-lg bg-primary text-neutral-900 font-bold hover:bg-primary-dark shadow-lg shadow-yellow-200/50 dark:shadow-none transition-all flex items-center gap-2 whitespace-nowrap shrink-0">
                <span class="material-symbols-outlined">add</span>
                Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm border border-neutral-100 dark:border-neutral-800 overflow-hidden animate-fade-in-up delay-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Jumlah Kuliner</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @forelse($categories as $category)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-neutral-100 to-neutral-200 dark:from-neutral-800 dark:to-neutral-700 overflow-hidden flex-shrink-0 shadow-md border-2 border-neutral-200 dark:border-neutral-700 group-hover:border-primary/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl">
                                    @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-2xl text-neutral-400 group-hover:text-primary transition-colors">category</span>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-bold text-base text-neutral-900 dark:text-white group-hover:text-primary transition-colors">{{ $category->name }}</span>
                                    @if($category->description)
                                    <p class="text-sm text-neutral-500 mt-1 line-clamp-1">{{ Str::limit($category->description, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">{{ $category->slug }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800 flex items-center gap-1.5 w-fit shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">restaurant</span>
                                {{ $category->kuliners_count }} kuliner
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors text-neutral-500 hover:text-neutral-900 dark:hover:text-white">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-red-500">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-neutral-500">
                            <span class="material-symbols-outlined text-4xl mb-2">category</span>
                            <p>Belum ada kategori</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 dark:border-neutral-800">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
