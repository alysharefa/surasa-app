<x-app-layout>
    <div class="bg-background-light dark:bg-background-dark min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10 text-center">
                <h1 class="text-3xl md:text-4xl font-black text-text-main-light dark:text-text-main-dark mb-2">
                    Pengaturan Profil
                </h1>
                <p class="text-text-sec-light dark:text-text-sec-dark text-lg">
                    Kelola informasi akun dan keamanan Anda.
                </p>
            </div>

            <div class="space-y-8">
                <!-- Profile Information -->
                <div class="bg-surface-light dark:bg-surface-dark p-8 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm">
                    <div class="flex items-start gap-6 mb-8">
                        <div class="hidden sm:flex size-16 rounded-full bg-primary/20 items-center justify-center text-primary text-2xl font-black shrink-0">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-text-main-light dark:text-text-main-dark flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">person</span>
                                Informasi Profil
                            </h2>
                            <p class="text-text-sec-light dark:text-text-sec-dark mt-1">Perbarui nama dan alamat email profil akun Anda.</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="name" class="block text-sm font-bold text-text-sec-light dark:text-text-sec-dark mb-2 uppercase tracking-wide">Nama Lengkap</label>
                            <input 
                                id="name" 
                                name="name" 
                                type="text" 
                                value="{{ old('name', $user->name) }}"
                                required
                                autofocus
                                autocomplete="name"
                                class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl px-5 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-medium text-text-main-light dark:text-text-main-dark placeholder-text-sec-light/50"
                            />
                            @error('name')
                                <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-text-sec-light dark:text-text-sec-dark mb-2 uppercase tracking-wide">Email</label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="username"
                                class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl px-5 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-medium text-text-main-light dark:text-text-main-dark placeholder-text-sec-light/50"
                            />
                            @error('email')
                                <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/10 rounded-xl border border-yellow-100 dark:border-yellow-900/30">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200 font-medium">
                                    Email Anda belum diverifikasi.
                                    <button form="send-verification" class="underline hover:text-yellow-900 dark:hover:text-yellow-100 font-bold ml-1">
                                        Kirim ulang verifikasi.
                                    </button>
                                </p>
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="px-8 py-3 bg-primary text-black rounded-full font-bold hover:brightness-105 hover:shadow-lg hover:shadow-primary/20 transition-all">
                                Simpan Perubahan
                            </button>
                            @if (session('status') === 'profile-updated')
                            <p class="text-sm font-bold text-green-600 flex items-center gap-1 animate-fade-in-up">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                Tersimpan
                            </p>
                            @endif
                        </div>
                    </form>
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">@csrf</form>
                </div>

                <!-- Update Password -->
                <div class="bg-surface-light dark:bg-surface-dark p-8 rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm">
                    <div class="flex items-start gap-6 mb-8">
                        <div class="hidden sm:flex size-16 rounded-full bg-primary/20 items-center justify-center text-primary text-2xl font-black shrink-0">
                            <span class="material-symbols-outlined text-3xl">lock</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-text-main-light dark:text-text-main-dark flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary md:hidden mb-1">lock</span>
                                Keamanan Password
                            </h2>
                            <p class="text-text-sec-light dark:text-text-sec-dark mt-1">Pastikan akun Anda aman dengan password yang kuat.</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-bold text-text-sec-light dark:text-text-sec-dark mb-2 uppercase tracking-wide">Password Saat Ini</label>
                            <input 
                                id="current_password" 
                                name="current_password" 
                                type="password" 
                                autocomplete="current-password"
                                class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl px-5 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-medium"
                            />
                            @error('current_password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-text-sec-light dark:text-text-sec-dark mb-2 uppercase tracking-wide">Password Baru</label>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                autocomplete="new-password"
                                class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl px-5 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-medium"
                            />
                            @error('password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-text-sec-light dark:text-text-sec-dark mb-2 uppercase tracking-wide">Konfirmasi Password</label>
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                autocomplete="new-password"
                                class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl px-5 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-medium"
                            />
                            @error('password_confirmation', 'updatePassword')
                                <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="px-8 py-3 bg-primary text-black rounded-full font-bold hover:brightness-105 hover:shadow-lg hover:shadow-primary/20 transition-all">
                                Update Password
                            </button>
                            @if (session('status') === 'password-updated')
                            <p class="text-sm font-bold text-green-600 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                Berhasil
                            </p>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Delete Account -->
                <div class="bg-red-50 dark:bg-red-900/10 p-8 rounded-[2rem] border border-red-100 dark:border-red-900/30">
                    <div class="flex items-start gap-6 mb-8">
                        <div class="hidden sm:flex size-16 rounded-full bg-red-100 dark:bg-red-900/30 items-center justify-center text-red-600 dark:text-red-400 text-2xl font-black shrink-0">
                            <span class="material-symbols-outlined text-3xl">warning</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-red-700 dark:text-red-400 flex items-center gap-2">
                                <span class="material-symbols-outlined md:hidden mb-1">warning</span>
                                Hapus Akun
                            </h2>
                            <p class="text-red-600/80 dark:text-red-400/80 mt-1">
                                Setelah akun dihapus, semua data dan resource yang terkait akan dihapus secara permanen.
                            </p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.destroy') }}" class="max-w-xl" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Tidak dapat dibatalkan.')">
                        @csrf
                        @method('delete')

                        <div class="mb-6">
                            <label for="delete_password" class="block text-sm font-bold text-red-700 dark:text-red-400 mb-2 uppercase tracking-wide">Konfirmasi Password Anda</label>
                            <input 
                                id="delete_password" 
                                name="password" 
                                type="password" 
                                placeholder="Masukkan password untuk konfirmasi"
                                class="w-full bg-white dark:bg-black/20 border border-red-200 dark:border-red-900/50 rounded-xl px-5 py-3 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all font-medium placeholder-red-300"
                            />
                            @error('password', 'userDeletion')
                                <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="px-8 py-3 bg-red-600 text-white rounded-full font-bold hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all">
                            Hapus Akun Saya
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
