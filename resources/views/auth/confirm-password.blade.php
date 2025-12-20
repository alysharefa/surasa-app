<x-app-layout>
    <div class="min-h-[calc(100vh-64px)] flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8 bg-background-light/50 dark:bg-background-dark/50">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-surface-light dark:bg-surface-dark py-8 px-4 shadow sm:rounded-2xl sm:px-10 border border-border-light dark:border-border-dark">
                
                <h1 class="text-2xl font-black mb-4 text-center text-text-main-light dark:text-text-main-dark">Konfirmasi Password</h1>

                <div class="mb-6 text-sm text-text-sec-light dark:text-text-sec-dark text-center">
                    {{ __('Ini adalah area aman aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.') }}
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-5">
                    @csrf

                    <!-- Password -->
                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('Password')" class="text-text-main-light dark:text-text-main-dark font-bold pl-2" />
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-sec-light dark:text-text-sec-dark pointer-events-none">lock</span>
                            <x-text-input id="password" class="block mt-1 w-full pl-12 rounded-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 focus:border-primary focus:ring-primary py-3"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password"
                                            placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 pl-2" />
                    </div>

                    <button type="submit" class="w-full justify-center py-3 bg-primary text-text-main-light rounded-full font-bold text-lg hover:brightness-95 transition-all shadow-lg mt-2 flex items-center gap-2">
                        {{ __('Konfirmasi') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
