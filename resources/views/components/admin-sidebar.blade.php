<!-- Desktop Sidebar -->
<aside class="w-72 h-full hidden lg:flex flex-col border-r border-neutral-200 dark:border-neutral-800 bg-surface-light dark:bg-surface-dark overflow-y-auto shrink-0 transition-all duration-300">
    <div class="p-6">
        <!-- Logo & Brand -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 mb-10 px-2 group">
            <div class="relative size-10">
                <img src="{{ asset('images/logo.png') }}" alt="SuRasa Logo" class="size-10 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 rounded-xl ring-1 ring-inset ring-black/5 dark:ring-white/10"></div>
            </div>
            <div class="flex flex-col">
                <h1 class="text-neutral-900 dark:text-white text-lg font-black tracking-tight leading-none group-hover:text-primary transition-colors">SuRasa<span class="text-primary">.</span>Admin</h1>
                <p class="text-neutral-500 dark:text-neutral-400 text-xs font-medium leading-tight mt-1">Platform Management</p>
            </div>
        </a>

        <!-- Navigation -->
        <nav class="flex flex-col gap-1.5">
            <p class="px-4 text-xs font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider mb-2">Menu Utama</p>
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('admin.dashboard') 
                   ? 'bg-primary text-text-main-light shadow-lg shadow-primary/25 translate-x-1' 
                   : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-text-main-light' : 'text-neutral-400 group-hover:text-neutral-900 dark:text-neutral-500 dark:group-hover:text-white' }} transition-colors">dashboard</span>
                <span class="text-sm font-bold">Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                <span class="absolute right-3 size-1.5 rounded-full bg-white/40"></span>
                @endif
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('admin.categories.*') 
                   ? 'bg-primary text-text-main-light shadow-lg shadow-primary/25 translate-x-1' 
                   : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.categories.*') ? 'text-text-main-light' : 'text-neutral-400 group-hover:text-neutral-900 dark:text-neutral-500 dark:group-hover:text-white' }} transition-colors">category</span>
                <span class="text-sm font-bold">Kategori</span>
            </a>

            <p class="px-4 text-xs font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider mt-6 mb-2">Konten</p>

            <!-- Culinary -->
            <a href="{{ route('admin.kuliners.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('admin.kuliners.*') 
                   ? 'bg-primary text-text-main-light shadow-lg shadow-primary/25 translate-x-1' 
                   : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.kuliners.*') ? 'text-text-main-light' : 'text-neutral-400 group-hover:text-neutral-900 dark:text-neutral-500 dark:group-hover:text-white' }} transition-colors">restaurant</span>
                <span class="text-sm font-bold">Kuliner</span>
            </a>

            <!-- Recipes -->
            <a href="{{ route('admin.recipes.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('admin.recipes.*') 
                   ? 'bg-primary text-text-main-light shadow-lg shadow-primary/25 translate-x-1' 
                   : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.recipes.*') ? 'text-text-main-light' : 'text-neutral-400 group-hover:text-neutral-900 dark:text-neutral-500 dark:group-hover:text-white' }} transition-colors">menu_book</span>
                <span class="text-sm font-bold">Resep</span>
            </a>

            <!-- Comments -->
            <a href="{{ route('admin.comments.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('admin.comments.*') 
                   ? 'bg-primary text-text-main-light shadow-lg shadow-primary/25 translate-x-1' 
                   : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.comments.*') ? 'text-text-main-light' : 'text-neutral-400 group-hover:text-neutral-900 dark:text-neutral-500 dark:group-hover:text-white' }} transition-colors">reviews</span>
                <span class="text-sm font-bold">Komentar</span>
            </a>

            <p class="px-4 text-xs font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider mt-6 mb-2">Pengguna</p>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
               {{ request()->routeIs('admin.users.*') 
                   ? 'bg-primary text-text-main-light shadow-lg shadow-primary/25 translate-x-1' 
                   : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.users.*') ? 'text-text-main-light' : 'text-neutral-400 group-hover:text-neutral-900 dark:text-neutral-500 dark:group-hover:text-white' }} transition-colors">group</span>
                <span class="text-sm font-bold">Users</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section -->
    <div class="mt-auto p-6 border-t border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/20">
        <!-- Back to Site -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors group mb-2">
            <span class="material-symbols-outlined text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white text-[20px]">arrow_back</span>
            <p class="text-neutral-600 dark:text-neutral-300 text-sm font-medium">Kembali ke Situs</p>
        </a>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen" 
     style="display: none;"
     class="fixed inset-0 z-40 lg:hidden" 
     role="dialog" 
     aria-modal="true">
    
    <!-- Backdrop -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm" 
         @click="sidebarOpen = false"></div>

    <!-- Off-canvas Menu -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative flex flex-col w-full max-w-xs h-full bg-surface-light dark:bg-surface-dark shadow-2xl">
        
        <!-- Close Button -->
        <div class="absolute top-0 right-0 -mr-12 pt-4">
            <button type="button" 
                    @click="sidebarOpen = false"
                    class="ml-1 flex items-center justify-center size-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <span class="sr-only">Close sidebar</span>
                <span class="material-symbols-outlined text-white text-[24px]">close</span>
            </button>
        </div>

        <!-- Sidebar Content (Duplicate of Desktop for now, can be extracted to partial if needed) -->
        <div class="flex-1 overflow-y-auto pt-5 pb-4">
            <div class="px-6 flex items-center gap-4 mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="SuRasa Logo" class="size-10 rounded-xl object-cover shadow-sm">
                <div>
                   <h1 class="text-neutral-900 dark:text-white text-lg font-black tracking-tight leading-none">SuRasa<span class="text-primary">.</span>Admin</h1> 
                </div>
            </div>
            
            <nav class="px-4 space-y-1">
                 <!-- Reusing the same links structure - ensuring consistency -->
                 <!-- Only showing main navigation items here tailored for mobile if needed, or exact copy -->
                 
                 <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('admin.dashboard') 
                       ? 'bg-primary text-text-main-light font-bold' 
                       : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="text-sm">Dashboard</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('admin.categories.*') 
                       ? 'bg-primary text-text-main-light font-bold' 
                       : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
                    <span class="material-symbols-outlined">category</span>
                    <span class="text-sm">Kategori</span>
                </a>
                
                <div class="h-px bg-neutral-200 dark:bg-neutral-800 my-4 mx-4"></div>

                <a href="{{ route('admin.kuliners.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('admin.kuliners.*') 
                       ? 'bg-primary text-text-main-light font-bold' 
                       : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
                    <span class="material-symbols-outlined">restaurant</span>
                    <span class="text-sm">Kuliner</span>
                </a>

                <a href="{{ route('admin.recipes.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('admin.recipes.*') 
                       ? 'bg-primary text-text-main-light font-bold' 
                       : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
                    <span class="material-symbols-outlined">menu_book</span>
                    <span class="text-sm">Resep</span>
                </a>

                <a href="{{ route('admin.comments.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('admin.comments.*') 
                       ? 'bg-primary text-text-main-light font-bold' 
                       : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
                    <span class="material-symbols-outlined">reviews</span>
                    <span class="text-sm">Komentar</span>
                </a>

                <div class="h-px bg-neutral-200 dark:bg-neutral-800 my-4 mx-4"></div>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('admin.users.*') 
                       ? 'bg-primary text-text-main-light font-bold' 
                       : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
                    <span class="material-symbols-outlined">group</span>
                    <span class="text-sm">Users</span>
                </a>
            </nav>
        </div>
    </div>
</div>


