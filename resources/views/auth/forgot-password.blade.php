<x-app-layout>
    <div class="min-h-[calc(100vh-64px)] flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8 bg-background-light/50 dark:bg-background-dark/50">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-surface-light dark:bg-surface-dark py-8 px-4 shadow sm:rounded-2xl sm:px-10 border border-border-light dark:border-border-dark">
                
                <!-- Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-black mb-2 text-text-main-light dark:text-text-main-dark">Lupa Password?</h1>
                    <p class="text-text-sec-light dark:text-text-sec-dark text-base">
                        Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link untuk reset password.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" class="text-text-main-light dark:text-text-main-dark font-bold pl-2" />
                        <div class="relative mt-2">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-text-sec-light dark:text-text-sec-dark pointer-events-none">mail</span>
                            <x-text-input 
                                id="email" 
                                type="email" 
                                name="email" 
                                :value="old('email')"
                                required 
                                autofocus
                                class="block w-full pl-12 rounded-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 focus:border-primary focus:ring-primary py-3"
                                placeholder="nama@email.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 pl-2" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 bg-primary text-text-main-light rounded-full font-bold text-lg hover:brightness-95 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined">send</span>
                        Kirim Link Reset Password
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-text-sec-light dark:text-text-sec-dark hover:text-primary transition-colors flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            Kembali ke halaman login
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
