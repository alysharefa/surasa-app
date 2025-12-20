<x-layouts.admin 
    title="Resep" 
    :header="'Moderasi Resep'" 
    :description="'Kelola dan moderasi resep yang dikirim pengguna'"
    :breadcrumbs="[['label' => 'Resep']]"
>
    <!-- Filters & Actions -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 flex flex-col md:flex-row justify-between items-center gap-4 mb-8 animate-fade-in-up delay-200">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.recipes.index') }}" 
               class="px-5 py-2.5 rounded-full font-medium text-sm transition-all {{ !$status || $status == 'all' ? 'bg-neutral-900 dark:bg-white text-white dark:text-neutral-900' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
                Semua
            </a>
            <a href="{{ route('admin.recipes.index', ['status' => 'approved']) }}" 
               class="px-5 py-2.5 rounded-full font-medium text-sm transition-all {{ $status == 'approved' ? 'bg-green-500 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
                Disetujui
            </a>
            <a href="{{ route('admin.recipes.index', ['status' => 'pending']) }}" 
               class="px-5 py-2.5 rounded-full font-medium text-sm transition-all {{ $status == 'pending' ? 'bg-yellow-500 text-black' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
                Pending
            </a>
        </div>

        <a href="{{ route('recipes.create') }}" class="h-12 px-6 rounded-lg bg-primary text-neutral-900 font-bold hover:bg-primary-dark shadow-lg shadow-yellow-200/50 dark:shadow-none transition-all flex items-center gap-2 whitespace-nowrap shrink-0">
            <span class="material-symbols-outlined">add</span>
            Tambah Resep
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm border border-neutral-100 dark:border-neutral-800 overflow-hidden animate-fade-in-up delay-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Resep</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Views</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @forelse($recipes as $recipe)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-xl bg-neutral-100 dark:bg-neutral-800 overflow-hidden flex-shrink-0 shadow-md border-2 border-neutral-200 dark:border-neutral-700 group-hover:border-primary/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl">
                                    @if($recipe->image)
                                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-3xl text-neutral-400 group-hover:text-primary transition-colors">menu_book</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-neutral-900 dark:text-white group-hover:text-primary transition-colors truncate">{{ $recipe->title }}</p>
                                    <p class="text-sm text-neutral-500 mt-1 line-clamp-2">{{ Str::limit($recipe->description, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-neutral-900 dark:text-white">{{ $recipe->user->name }}</p>
                            <p class="text-sm text-neutral-500">{{ $recipe->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($recipe->is_approved)
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 flex items-center gap-1.5 w-fit shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                Disetujui
                            </span>
                            @else
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-yellow-100 to-orange-100 dark:from-yellow-900/20 dark:to-orange-900/20 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 flex items-center gap-1.5 w-fit shadow-sm animate-pulse">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-neutral-600 dark:text-neutral-400">{{ $recipe->views }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.recipes.show', $recipe) }}" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors text-neutral-500 hover:text-neutral-900 dark:hover:text-white" title="Lihat">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>
                                @if(!$recipe->is_approved)
                                <form action="{{ route('admin.recipes.approve', $recipe) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 rounded-full hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors text-green-500" title="Setujui">
                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.recipes.reject', $recipe) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 rounded-full hover:bg-yellow-50 dark:hover:bg-yellow-900/10 transition-colors text-yellow-500" title="Tolak">
                                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Hapus resep ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-red-500" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-neutral-500">
                            <span class="material-symbols-outlined text-4xl mb-2">menu_book</span>
                            <p>Belum ada resep</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recipes->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 dark:border-neutral-800">
            {{ $recipes->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
