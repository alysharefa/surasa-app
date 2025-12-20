<x-app-layout>
    <div class="min-h-[calc(100vh-80px)] flex bg-background-light dark:bg-background-dark">
        <!-- Left Side: Image -->
        <div class="hidden lg:block w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 hover:scale-105" style="background-image: url('{{ asset('images/hero_1.png') }}');"></div>
            <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
            <div class="absolute inset-0 flex flex-col justify-between p-16 text-white">
                <div>
                    <h2 class="text-4xl font-black mb-4">Selamat Datang Kembali!</h2>
                    <p class="text-lg text-white/90 max-w-md">Siap untuk membagikan resep andalanmu hari ini? Komunitas sudah menunggu!</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex -space-x-4">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=A&background=random" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=B&background=random" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=C&background=random" alt="">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="font-bold text-sm">1.5k+ Komunitas</span>
                        <span class="text-xs text-white/80">Bergabunglah sekarang</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-16 animate-page-load">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-black text-text-main-light dark:text-text-main-dark mb-2">Masuk ke Akun</h1>
                    <p class="text-text-sec-light dark:text-text-sec-dark">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-primary hover:text-primary-dark transition-colors">Daftar sekarang</a></p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-bold text-text-main-light dark:text-text-main-dark ml-1">Alamat Email</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-sec-light dark:text-text-sec-dark group-focus-within:text-primary transition-colors">mail</span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="user@example.com"
                                class="w-full pl-12 pr-4 py-3.5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-text-main-light dark:text-text-main-dark placeholder:text-text-sec-light/50 dark:placeholder:text-text-sec-dark/50">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="ml-1" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label for="password" class="text-sm font-bold text-text-main-light dark:text-text-main-dark">Password</label>
                            @if (Route::has('password.request'))
                            <a class="text-xs font-medium text-primary hover:text-primary-dark transition-colors" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-sec-light dark:text-text-sec-dark group-focus-within:text-primary transition-colors">lock</span>
                            <input id="password" type="password" name="password" required placeholder="Masukan password"
                                class="w-full pl-12 pr-4 py-3.5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-text-main-light dark:text-text-main-dark placeholder:text-text-sec-light/50 dark:placeholder:text-text-sec-dark/50">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="ml-1" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center ml-1">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-border-light dark:border-border-dark text-primary focus:ring-primary bg-surface-light dark:bg-surface-dark cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-text-sec-light dark:text-text-sec-dark cursor-pointer select-none">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary text-text-main-light rounded-2xl font-bold text-lg hover:brightness-95 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Masuk Sekarang</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                    
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-border-light dark:border-border-dark"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-background-light dark:bg-background-dark text-text-sec-light dark:text-text-sec-dark font-medium">Atau masuk dengan</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <button type="button" class="flex-1 py-2.5 border border-border-light dark:border-border-dark rounded-xl flex items-center justify-center gap-2 hover:bg-surface-light dark:hover:bg-surface-dark transition-colors">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                            <span class="font-medium text-text-main-light dark:text-text-main-dark">Google</span>
                        </button>
                        <button type="button" class="flex-1 py-2.5 border border-border-light dark:border-border-dark rounded-xl flex items-center justify-center gap-2 hover:bg-surface-light dark:hover:bg-surface-dark transition-colors">
                            <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-5 h-5" alt="Facebook">
                            <span class="font-medium text-text-main-light dark:text-text-main-dark">Facebook</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
