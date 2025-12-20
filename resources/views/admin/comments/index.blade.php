<x-layouts.admin 
    title="Komentar" 
    :header="'Moderasi Komentar'" 
    :description="'Kelola dan moderasi komentar pengguna'"
    :breadcrumbs="[['label' => 'Komentar']]"
>
    <!-- Filters -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 flex flex-wrap gap-3 mb-8 animate-fade-in-up delay-200">
        <a href="{{ route('admin.comments.index') }}" 
           class="px-6 py-2.5 rounded-full font-bold text-sm transition-all {{ !$status || $status == 'all' ? 'bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 shadow-md' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
            Semua
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" 
           class="px-6 py-2.5 rounded-full font-bold text-sm transition-all {{ $status == 'approved' ? 'bg-green-600 text-white shadow-md shadow-green-200/50 dark:shadow-none' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
            Disetujui
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" 
           class="px-6 py-2.5 rounded-full font-bold text-sm transition-all {{ $status == 'pending' ? 'bg-yellow-500 text-black shadow-md shadow-yellow-200/50 dark:shadow-none' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-700' }}">
            Pending
        </a>
    </div>

    <!-- Comments List -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl shadow-neutral-100/50 dark:shadow-none border border-neutral-100 dark:border-neutral-800 overflow-hidden animate-fade-in-up delay-300">
        <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
            @forelse($comments as $comment)
            <div class="p-6 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors group">
                <div class="flex items-start justify-between gap-6">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0 text-primary font-bold text-xl uppercase">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <span class="font-bold text-neutral-900 dark:text-white">{{ $comment->user->name }}</span>
                                <span class="text-neutral-400 text-sm">•</span>
                                <span class="text-neutral-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="bg-neutral-50 dark:bg-neutral-800/50 p-4 rounded-lg rounded-tl-none mb-3 border border-neutral-100 dark:border-neutral-800">
                                <p class="text-neutral-700 dark:text-neutral-200 leading-relaxed">{{ $comment->content }}</p>
                            </div>
                            <div class="flex items-center gap-4 text-sm">
                                <span class="text-neutral-500">pada</span>
                                <a href="{{ route('kuliners.show', $comment->kuliner->slug ?? '#') }}" class="text-primary hover:text-primary-dark font-bold hover:underline transition-colors">
                                    {{ $comment->kuliner->name ?? 'Kuliner Dihapus' }}
                                </a>
                                <div class="w-1 h-1 rounded-full bg-neutral-300"></div>
                                @if($comment->is_approved)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span> Disetujui
                                </span>
                                @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">hourglass_top</span> Pending
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0 opacity-0 group-hover:opacity-100 transition-all duration-200">
                        @if(!$comment->is_approved)
                        <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors text-green-500 tooltip-trigger" title="Setujui">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="p-2 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/10 transition-colors text-yellow-500 tooltip-trigger" title="Tolak">
                                <span class="material-symbols-outlined text-[20px]">cancel</span>
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-red-500 tooltip-trigger" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-16 text-center text-neutral-500">
                <span class="material-symbols-outlined text-5xl mb-4 text-neutral-300">forum</span>
                <p class="text-lg font-medium">Belum ada komentar</p>
            </div>
            @endforelse
        </div>

        @if($comments->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-800/50">
            {{ $comments->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
