<x-app-layout>
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-background-light dark:bg-background-dark min-h-[calc(100vh-64px)] flex items-center">
        <!-- Background Blobs -->
        <div class="absolute top-0 right-0 -translate-y-1/4 translate-x-1/4 w-[500px] h-[500px] bg-primary/20 rounded-full blur-3xl opacity-50 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/4 -translate-x-1/4 w-[400px] h-[400px] bg-primary/10 rounded-full blur-3xl opacity-50 animate-pulse delay-700"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative w-full py-12 lg:py-0">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                <!-- Text Content -->
                <div class="text-center lg:text-left space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-surface-light dark:bg-surface-dark rounded-full border border-border-light dark:border-border-dark shadow-sm animate-fade-in-up">
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-primary"></span>
                        </span>
                        <span class="text-sm font-bold text-text-sec-light dark:text-text-sec-dark tracking-wide">Platform Kuliner #1 Indonesia</span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-serif font-black leading-tight text-text-main-light dark:text-text-main-dark animate-fade-in-up delay-100">
                        Jelajahi Rasa 
                        <span class="relative inline-block text-transparent bg-clip-text bg-gradient-to-r from-primary to-orange-400">
                            Nusantara
                            <svg class="absolute w-full h-3 -bottom-1 left-0 text-primary opacity-40" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="4" fill="none" />
                            </svg>
                        </span>
                    </h1>

                    <p class="text-lg lg:text-xl text-text-sec-light dark:text-text-sec-dark max-w-2xl mx-auto lg:mx-0 leading-relaxed animate-fade-in-up delay-200">
                        Temukan ribuan resep autentik dan rekomendasi kuliner terbaik dari seluruh penjuru Indonesia. Bergabunglah dengan komunitas pecinta makanan sekarang.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4 animate-fade-in-up delay-300">
                        <a href="{{ route('kuliners.index') }}" class="px-8 py-4 bg-primary text-text-main-light rounded-full font-bold text-lg hover:brightness-95 transition-all shadow-lg shadow-primary/25 flex items-center justify-center gap-2 group">
                            <span class="material-symbols-outlined group-hover:rotate-12 transition-transform">restaurant_menu</span>
                            Mulai Jelajah
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark border border-border-light dark:border-border-dark rounded-full font-bold text-lg hover:border-primary transition-all flex items-center justify-center gap-2">
                            Gabung Komunitas
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="pt-8 flex items-center justify-center lg:justify-start gap-8 lg:gap-12 animate-fade-in-up delay-400">
                        <div>
                            <p class="text-3xl font-serif font-bold text-text-main-light dark:text-text-main-dark">500+</p>
                            <p class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Kuliner</p>
                        </div>
                        <div class="w-px h-10 bg-border-light dark:bg-border-dark"></div>
                        <div>
                            <p class="text-3xl font-serif font-bold text-text-main-light dark:text-text-main-dark">10k+</p>
                            <p class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Pengguna</p>
                        </div>
                        <div class="w-px h-10 bg-border-light dark:bg-border-dark"></div>
                        <div>
                            <p class="text-3xl font-serif font-bold text-text-main-light dark:text-text-main-dark">4.9</p>
                            <p class="text-sm text-text-sec-light dark:text-text-sec-dark font-medium">Rating App</p>
                        </div>
                    </div>
                </div>

                <!-- Visual Content -->
                <div class="relative hidden lg:block animate-fade-in-up delay-500">
                    <div class="relative z-10 grid grid-cols-2 gap-4">
                        <div class="space-y-4 translate-y-12">
                            <div class="bg-surface-light dark:bg-surface-dark p-3 rounded-2xl shadow-xl border border-border-light dark:border-border-dark transform hover:-translate-y-2 transition-transform duration-500">
                                <div class="aspect-[4/5] rounded-xl overflow-hidden bg-gray-100">
                                    <img src="{{ asset('images/hero_1.png') }}" alt="Nasi Goreng" class="w-full h-full object-cover">
                                </div>
                                <div class="pt-3 px-1">
                                    <h4 class="font-bold text-text-main-light dark:text-text-main-dark truncate">Nasi Goreng Spesial</h4>
                                    <div class="flex items-center gap-1 text-primary text-sm">
                                        <span class="material-symbols-outlined text-[14px] fill-current">star</span>
                                        <span class="font-bold text-text-main-light dark:text-text-main-dark">4.9</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-xl border border-border-light dark:border-border-dark max-w-[200px] ml-auto transform hover:-translate-y-2 transition-transform duration-500">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <span class="material-symbols-outlined">eco</span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-text-sec-light dark:text-text-sec-dark">Kategori</p>
                                        <p class="font-bold text-text-main-light dark:text-text-main-dark">Halal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-xl border border-border-light dark:border-border-dark max-w-[200px] transform hover:-translate-y-2 transition-transform duration-500">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                                        <span class="material-symbols-outlined">local_fire_department</span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-text-sec-light dark:text-text-sec-dark">Trending</p>
                                        <p class="font-bold text-text-main-light dark:text-text-main-dark">Pedas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-surface-light dark:bg-surface-dark p-3 rounded-2xl shadow-xl border border-border-light dark:border-border-dark transform hover:-translate-y-2 transition-transform duration-500">
                                <div class="aspect-[4/5] rounded-xl overflow-hidden bg-gray-100">
                                    <img src="{{ asset('images/hero_2.png') }}" alt="Sate Ayam" class="w-full h-full object-cover">
                                </div>
                                <div class="pt-3 px-1">
                                    <h4 class="font-bold text-text-main-light dark:text-text-main-dark truncate">Sate Ayam Madura</h4>
                                    <div class="flex items-center gap-1 text-primary text-sm">
                                        <span class="material-symbols-outlined text-[14px] fill-current">star</span>
                                        <span class="font-bold text-text-main-light dark:text-text-main-dark">5.0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
        .delay-700 { animation-delay: 700ms; }
        .delay-1000 { animation-delay: 1000ms; }
    </style>
</x-app-layout>
