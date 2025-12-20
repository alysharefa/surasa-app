<x-app-layout>
    <div class="min-h-[calc(100vh-80px)] flex bg-background-light dark:bg-background-dark">
        <!-- Left Side: Image -->
        <div class="hidden lg:block w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 hover:scale-105" style="background-image: url('{{ asset('images/hero_2.png') }}');"></div>
            <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
            <div class="absolute inset-0 flex flex-col justify-between p-16 text-white">
                <div>
                    <h2 class="text-4xl font-black mb-4">Mulai Petualangan Kuliner!</h2>
                    <p class="text-lg text-white/90 max-w-md">Temukan ribuan resep autentik, bagikan kreasimu, dan terhubung dengan pecinta makanan lainnya.</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
                        <span class="material-symbols-outlined text-yellow-400">star</span>
                        <span class="font-bold">4.9/5 Rating Komunitas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-16 animate-page-load">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-black text-text-main-light dark:text-text-main-dark mb-2">Buat Akun Baru</h1>
                    <p class="text-text-sec-light dark:text-text-sec-dark">Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary-dark transition-colors">Masuk di sini</a></p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-bold text-text-main-light dark:text-text-main-dark ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-sec-light dark:text-text-sec-dark group-focus-within:text-primary transition-colors">person</span>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama lengkap Anda"
                                class="w-full pl-12 pr-4 py-3.5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-text-main-light dark:text-text-main-dark placeholder:text-text-sec-light/50 dark:placeholder:text-text-sec-dark/50">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="ml-1" />
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-bold text-text-main-light dark:text-text-main-dark ml-1">Alamat Email</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-sec-light dark:text-text-sec-dark group-focus-within:text-primary transition-colors">mail</span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com"
                                class="w-full pl-12 pr-4 py-3.5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-text-main-light dark:text-text-main-dark placeholder:text-text-sec-light/50 dark:placeholder:text-text-sec-dark/50">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="ml-1" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-bold text-text-main-light dark:text-text-main-dark ml-1">Password</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-sec-light dark:text-text-sec-dark group-focus-within:text-primary transition-colors">lock</span>
                            <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                                class="w-full pl-12 pr-4 py-3.5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-text-main-light dark:text-text-main-dark placeholder:text-text-sec-light/50 dark:placeholder:text-text-sec-dark/50">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="ml-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-bold text-text-main-light dark:text-text-main-dark ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-sec-light dark:text-text-sec-dark group-focus-within:text-primary transition-colors">lock_reset</span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi password"
                                class="w-full pl-12 pr-4 py-3.5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-text-main-light dark:text-text-main-dark placeholder:text-text-sec-light/50 dark:placeholder:text-text-sec-dark/50">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="ml-1" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-4 bg-primary text-text-main-light rounded-2xl font-bold text-lg hover:brightness-95 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Daftar Sekarang</span>
                            <span class="material-symbols-outlined">rocket_launch</span>
                        </button>
                    </div>

                    <p class="text-xs text-center text-text-sec-light dark:text-text-sec-dark mt-4">
                        Dengan mendaftar, Anda menyetujui <a href="#" class="text-primary hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a> kami.
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
