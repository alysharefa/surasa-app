<x-layouts.admin 
    title="Tambah Kategori" 
    :header="'Tambah Kategori Baru'" 
    :description="'Buat kategori baru untuk mengelompokkan kuliner'"
    :breadcrumbs="[['label' => 'Kategori', 'url' => route('admin.categories.index')], ['label' => 'Tambah Baru']]"
>
    <div class="max-w-4xl mx-auto">
        <form id="category-form" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Info -->
                <div class="lg:col-span-2 flex flex-col gap-8">
                    
                    <!-- Basic Info Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">category</span>
                            Informasi Kategori
                        </h3>
                        
                        <div class="space-y-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Nama Kategori <span class="text-red-500">*</span></span>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                                       placeholder="Contoh: Street Food">
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </label>

                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Deskripsi</span>
                                <textarea name="description" rows="4"
                                          class="w-full p-4 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white resize-y leading-relaxed"
                                          placeholder="Deskripsi singkat tentang kategori ini...">{{ old('description') }}</textarea>
                                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Media & Actions -->
                <div class="flex flex-col gap-8">
                    
                    <!-- Actions Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up delay-100 sticky top-24">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6">Simpan Data</h3>
                        
                        <div class="flex flex-col gap-3">
                            <button type="submit" class="w-full px-6 py-3.5 rounded-xl bg-primary text-neutral-900 font-bold hover:brightness-105 shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">save</span>
                                Simpan Kategori
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="w-full px-6 py-3.5 rounded-xl bg-transparent border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 font-bold hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-all text-center">
                                Batal
                            </a>
                        </div>
                    </div>

                    <!-- Media Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up delay-200">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">image</span>
                            Foto Sampul
                        </h3>
                        
                        <!-- Image Preview -->
                        <div id="image-preview-container" class="hidden w-full mb-4">
                            <div class="relative w-full aspect-square rounded-xl overflow-hidden shadow-md border-2 border-primary group">
                                <img id="image-preview" src="" alt="Preview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" id="remove-image" class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-600 transition-colors flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]">delete</span> Hapus
                                    </button>
                                </div>
                            </div>
                            <p id="file-name" class="mt-2 text-xs text-neutral-500 text-center truncate"></p>
                        </div>
                        
                        <!-- Upload Area -->
                        <label id="upload-label" class="w-full border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-xl p-6 flex flex-col items-center justify-center gap-3 hover:border-primary hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-all cursor-pointer group bg-background-light dark:bg-background-dark">
                            <input type="file" name="image" accept="image/*" class="hidden" id="image-input">
                            <div class="bg-neutral-100 dark:bg-neutral-800 p-3 rounded-full group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl text-neutral-400 dark:text-neutral-500 group-hover:text-primary">add_photo_alternate</span>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-bold text-neutral-900 dark:text-white group-hover:text-primary transition-colors">Upload Foto</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">PNG, JPG (Max. 2MB)</p>
                            </div>
                        </label>
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
        </form>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const previewContainer = document.getElementById('image-preview-container');
    const uploadLabel = document.getElementById('upload-label');
    const removeBtn = document.getElementById('remove-image');
    const fileName = document.getElementById('file-name');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    uploadLabel.classList.add('hidden');
                    fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                }
                reader.readAsDataURL(file);
            }
        });

        removeBtn.addEventListener('click', function() {
            imageInput.value = '';
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
            uploadLabel.classList.remove('hidden');
        });
    }
});
</script>

</x-layouts.admin>
