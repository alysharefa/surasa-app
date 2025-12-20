<nav class="sticky top-0 z-30 flex items-center justify-between px-6 py-4 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 transition-all duration-300">
    <div class="flex items-center gap-4">
        <!-- Mobile Menu Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 lg:hidden text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <!-- Page Title (Optional context) -->
        <div class="hidden md:flex flex-col">
            <h2 class="text-lg font-bold text-neutral-900 dark:text-white leading-tight">
                {{ $title ?? 'Admin Dashboard' }}
            </h2>
            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                {{ date('l, d F Y') }}
            </p>
        </div>
    </div>

    <!-- Right Actions -->
    <div class="flex items-center gap-3">
        <!-- Theme Toggle (Future proofing placeholder or reusing if logic exists) -->
        <!-- For now, we focus on User Dropdown -->

        <!-- User Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-3 p-1 pl-3 pr-2 rounded-full border border-neutral-200 dark:border-neutral-800 bg-surface-light dark:bg-surface-dark hover:border-primary/50 transition-colors group">
                <div class="flex flex-col text-right hidden sm:flex">
                    <span class="text-xs font-bold text-neutral-900 dark:text-white">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-neutral-500 dark:text-neutral-400">{{ auth()->user()->role ?? 'Admin' }}</span>
                </div>
                <div class="size-8 rounded-full bg-primary text-text-main-light flex items-center justify-center font-bold text-sm shadow-sm">
                   {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="material-symbols-outlined text-neutral-400 group-hover:text-primary transition-colors text-sm">expand_more</span>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                 class="absolute right-0 mt-2 w-56 bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl border border-neutral-100 dark:border-neutral-800 py-2 z-50 transform origin-top-right">
                
                <div class="px-4 py-2 border-b border-neutral-100 dark:border-neutral-800 sm:hidden">
                    <p class="text-sm font-bold text-neutral-900 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-neutral-500">{{ auth()->user()->email }}</p>
                </div>

                <div class="p-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                        Profile
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[18px]">public</span>
                        View Website
                    </a>
                </div>

                <div class="border-t border-neutral-100 dark:border-neutral-800 mt-1 p-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-3 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
