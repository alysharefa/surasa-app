<x-app-layout>
    <div class="min-h-[calc(100vh-64px)] flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8 bg-background-light/50 dark:bg-background-dark/50">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-surface-light dark:bg-surface-dark py-8 px-4 shadow sm:rounded-2xl sm:px-10 border border-border-light dark:border-border-dark text-center">
                
                <h1 class="text-2xl font-black mb-4 text-text-main-light dark:text-text-main-dark">Verifikasi Email</h1>
                
                <div class="mb-6 text-sm text-text-sec-light dark:text-text-sec-dark">
                    {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkannya lagi.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 font-medium text-sm text-green-600 dark:text-green-400 p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
                        {{ __('Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
                    </div>
                @endif

                <div class="mt-6 flex flex-col gap-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-primary text-text-main-light rounded-full font-bold text-lg hover:brightness-95 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                            {{ __('Kirim Ulang Email Verifikasi') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-text-sec-light dark:text-text-sec-dark hover:text-primary transition-colors underline">
                            {{ __('Keluar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
