<x-layouts.admin 
    title="Users" 
    :header="'Kelola Users'" 
    :description="'Lihat dan kelola semua pengguna'"
    :breadcrumbs="[['label' => 'Users']]"
>
    <x-slot name="actions">
        <a href="{{ route('admin.users.create') }}" class="px-6 py-3 rounded-full bg-primary text-black font-bold hover:bg-yellow-400 shadow-lg shadow-yellow-200/50 dark:shadow-none transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">person_add</span>
            Tambah User
        </a>
    </x-slot>

    <!-- Actions & Filter -->
    <div class="relative z-20 bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 mb-8 animate-fade-in-up delay-200">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Search -->
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex-1 w-full md:w-auto">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari user..." 
                           class="w-full h-12 pl-12 pr-5 rounded-lg bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white placeholder:text-neutral-400">
                </div>
            </form>

            <div class="relative min-w-[200px]" x-data="{ open: false }">
                <!-- Hidden Input -->
                <input type="hidden" name="role" x-ref="roleInput" value="{{ request('role') }}">

                <!-- Trigger Button -->
                <button type="button" 
                        @click="open = !open" 
                        @click.away="open = false" 
                        class="w-full h-12 pl-12 pr-10 flex items-center text-left rounded-lg bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none text-neutral-900 dark:text-white cursor-pointer hover:border-primary transition-colors group">
                    <span class="material-symbols-outlined absolute left-4 text-neutral-400 group-hover:text-primary transition-colors">filter_list</span>
                    <span class="line-clamp-1 block flex-1 text-sm font-medium">
                        @if(request('role'))
                            {{ ucfirst(request('role')) }}
                        @else
                            Semua Role
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
                     class="absolute z-50 w-full mt-2 bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl shadow-neutral-200/50 dark:shadow-none border border-neutral-100 dark:border-neutral-800 overflow-hidden">
                    
                    <div class="p-1.5 space-y-0.5">
                        <button type="button" 
                                @click="$refs.roleInput.value = ''; $el.closest('form').submit()"
                                class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm font-medium flex items-center justify-between group
                                {{ !request('role') ? 'bg-primary/10 text-primary dark:text-primary' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-white' }}">
                            <span>Semua Role</span>
                            @if(!request('role'))
                            <span class="material-symbols-outlined text-[18px]">check</span>
                            @endif
                        </button>
                        @foreach(['admin', 'user'] as $role)
                        <button type="button" 
                                @click="$refs.roleInput.value = '{{ $role }}'; $el.closest('form').submit()"
                                class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm font-medium flex items-center justify-between group
                                {{ request('role') == $role ? 'bg-primary/10 text-primary dark:text-primary' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-white' }}">
                            <span>{{ ucfirst($role) }}</span>
                            @if(request('role') == $role)
                            <span class="material-symbols-outlined text-[18px]">check</span>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm border border-neutral-100 dark:border-neutral-800 overflow-hidden animate-fade-in-up delay-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @forelse($users as $user)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-primary font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-neutral-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-sm text-neutral-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role == 'admin')
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400">Admin</span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $user->ratings_count }} rating, {{ $user->comments_count }} komentar, {{ $user->recipes_count }} resep
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors text-neutral-500 hover:text-neutral-900 dark:hover:text-white" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.change-role', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 rounded-full hover:bg-yellow-50 dark:hover:bg-yellow-900/10 transition-colors text-yellow-500" title="{{ $user->role == 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}">
                                        <span class="material-symbols-outlined text-[20px]">swap_horiz</span>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-red-500" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-neutral-500">
                            <span class="material-symbols-outlined text-4xl mb-2">group</span>
                            <p>Belum ada user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 dark:border-neutral-800">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
