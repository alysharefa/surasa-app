<footer class="bg-surface-light dark:bg-surface-dark border-t border-border-light dark:border-border-dark pt-16 pb-24 md:pb-8 relative overflow-hidden">
    <!-- Decorative Pattern -->
    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary via-primary-dark to-primary"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
            <!-- Brand -->
            <div class="lg:col-span-4 space-y-6">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="size-12">
                        <img src="{{ asset('images/logo.png') }}" alt="SuRasa Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="text-2xl font-bold font-serif text-text-main-light dark:text-text-main-dark">SuRasa</span>
                </a>
                <p class="text-text-sec-light dark:text-text-sec-dark leading-relaxed">
                    Platform kuliner nomor 1 di Indonesia yang menghubungkan jutaan pecinta makanan dengan cita rasa autentik Nusantara. Temukan, bagikan, dan nikmati warisan kuliner kita.
                </p>
                <div class="flex items-center gap-4">
                    <a href="#" class="size-10 rounded-full bg-background-light dark:bg-background-dark flex items-center justify-center text-text-sec-light dark:text-text-sec-dark hover:bg-primary hover:text-text-main-light transition-all">
                        <span class="material-symbols-outlined text-xl">thumb_up</span>
                    </a>
                    <a href="#" class="size-10 rounded-full bg-background-light dark:bg-background-dark flex items-center justify-center text-text-sec-light dark:text-text-sec-dark hover:bg-primary hover:text-text-main-light transition-all">
                        <span class="material-symbols-outlined text-xl">photo_camera</span>
                    </a>
                    <a href="#" class="size-10 rounded-full bg-background-light dark:bg-background-dark flex items-center justify-center text-text-sec-light dark:text-text-sec-dark hover:bg-primary hover:text-text-main-light transition-all">
                        <span class="material-symbols-outlined text-xl">share</span>
                    </a>
                </div>
            </div>

            <!-- Links Sections -->
            <div class="lg:col-span-2">
                <h4 class="font-bold text-lg text-text-main-light dark:text-text-main-dark mb-6">Jelajahi</h4>
                <ul class="space-y-4 text-sm text-text-sec-light dark:text-text-sec-dark">
                    <li><a href="{{ route('kuliners.index') }}" class="hover:text-primary-dark transition-colors">Kuliner Nusantara</a></li>
                    <li><a href="{{ route('recipes.index') }}" class="hover:text-primary-dark transition-colors">Resep Pilihan</a></li>
                    <li><a href="#" class="hover:text-primary-dark transition-colors">Kategori Populer</a></li>
                    <li><a href="#" class="hover:text-primary-dark transition-colors">Restoran Terdekat</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h4 class="font-bold text-lg text-text-main-light dark:text-text-main-dark mb-6">Perusahaan</h4>
                <ul class="space-y-4 text-sm text-text-sec-light dark:text-text-sec-dark">
                    <li><a href="#" class="hover:text-primary-dark transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-primary-dark transition-colors">Karir</a></li>
                    <li><a href="#" class="hover:text-primary-dark transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-primary-dark transition-colors">Mitra</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h4 class="font-bold text-lg text-text-main-light dark:text-text-main-dark mb-6">Hubungi Kami</h4>
                <ul class="space-y-4 text-sm text-text-sec-light dark:text-text-sec-dark">
                    <li class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-primary-dark text-xl mt-0.5">location_on</span>
                        <span>
                            Jl. Jendral Sudirman No. 123<br>
                            Jakarta Selatan, DKI Jakarta 12190
                        </span>
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-primary-dark text-xl">mail</span>
                        hello@surasa.id
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-primary-dark text-xl">call</span>
                        +62 812 3456 7890
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-border-light dark:border-border-dark pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-text-sec-light dark:text-text-sec-dark">
            <p>© {{ date('Y') }} SuRasa. All rights reserved.</p>
            <div class="flex gap-8">
                <a href="#" class="hover:text-primary-dark transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-primary-dark transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
