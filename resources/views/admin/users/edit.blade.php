<x-layouts.admin 
    title="Edit User" 
    :header="'Edit User'" 
    :description="'Perbarui informasi pengguna'"
    :breadcrumbs="[['label' => 'Users', 'url' => route('admin.users.index')], ['label' => 'Edit']]"
>
    <!-- Actions -->
    <div class="flex justify-end gap-3 mb-8">
        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-lg bg-transparent border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white font-medium hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all">
            Batal
        </a>
        <button type="submit" form="user-form" class="px-6 py-3 rounded-lg bg-primary text-neutral-900 font-bold hover:bg-primary-dark shadow-lg shadow-yellow-200/50 dark:shadow-none transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">save</span>
            Update User
        </button>
    </div>

    <div class="max-w-2xl">
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 md:p-10 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <form id="user-form" action="{{ route('admin.users.update', $user) }}" method="POST" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Nama *</span>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full h-14 px-5 rounded-lg bg-background-light dark:bg-background-dark border {{ $errors->has('name') ? 'border-red-500' : 'border-neutral-200 dark:border-neutral-700' }} focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                    @error('name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </label>

                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Email *</span>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full h-14 px-5 rounded-lg bg-background-light dark:bg-background-dark border {{ $errors->has('email') ? 'border-red-500' : 'border-neutral-200 dark:border-neutral-700' }} focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                    @error('email')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </label>

                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Role *</span>
                    <div class="relative">
                        <select name="role" required
                                class="w-full h-14 px-5 pr-10 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white appearance-none cursor-pointer">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-neutral-500 material-symbols-outlined">expand_more</span>
                    </div>
                </label>

                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Password Baru</span>
                    <input type="password" name="password"
                           class="w-full h-14 px-5 rounded-lg bg-background-light dark:bg-background-dark border {{ $errors->has('password') ? 'border-red-500' : 'border-neutral-200 dark:border-neutral-700' }} focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                           placeholder="Kosongkan jika tidak ingin mengubah">
                    @error('password')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </label>

                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Konfirmasi Password Baru</span>
                    <input type="password" name="password_confirmation"
                           class="w-full h-14 px-5 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                           placeholder="Kosongkan jika tidak ingin mengubah">
                </label>
            </form>
        </div>
    </div>
</x-layouts.admin>
