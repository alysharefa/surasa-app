<x-layouts.admin 
    title="Edit Kategori" 
    :header="'Edit Kategori'" 
    :description="'Perbarui informasi kategori'"
    :breadcrumbs="[['label' => 'Kategori', 'url' => route('admin.categories.index')], ['label' => 'Edit']]"
>
    <!-- Actions -->
    <div class="flex justify-end gap-3 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 rounded-lg bg-transparent border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white font-medium hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all">
            Batal
        </a>
        <button type="submit" form="category-form" class="px-6 py-3 rounded-lg bg-primary text-neutral-900 font-bold hover:bg-primary-dark shadow-lg shadow-yellow-200/50 dark:shadow-none transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">save</span>
            Update Kategori
        </button>
    </div>

    <div class="max-w-2xl">
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 md:p-10 shadow-sm border border-neutral-100 dark:border-neutral-800">
            <form id="category-form" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Nama Kategori *</span>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full h-14 px-5 rounded-lg bg-background-light dark:bg-background-dark border {{ $errors->has('name') ? 'border-red-500' : 'border-neutral-200 dark:border-neutral-700' }} focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                    @error('name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </label>

                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Deskripsi</span>
                    <textarea name="description" rows="3"
                              class="w-full p-5 rounded-lg bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white resize-y">{{ old('description', $category->description) }}</textarea>
                </label>

                <div class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Gambar (Opsional)</span>
                    @if($category->image)
                    <div id="current-image-container" class="flex items-center gap-4 mb-2 p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-20 h-20 rounded-xl object-cover shadow-md">
                        <div>
                            <p class="text-sm font-bold text-neutral-700 dark:text-neutral-300 flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-500 text-[18px]">check_circle</span>
                                Gambar saat ini
                            </p>
                            <p class="text-xs text-neutral-500 mt-1">Upload gambar baru untuk mengganti</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Image Preview Container -->
                    <div id="image-preview-container" class="hidden w-full mb-4">
                        <div class="relative inline-block">
                            <img id="image-preview" src="" alt="Preview" class="max-w-xs h-auto rounded-xl shadow-lg border-2 border-primary">
                            <button type="button" id="remove-image" class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                        </div>
                        <p id="file-name" class="mt-3 text-sm text-neutral-600 dark:text-neutral-400"></p>
                    </div>
                    
                    <label id="upload-label" class="w-full border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-lg p-8 flex flex-col items-center justify-center gap-3 hover:border-primary hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-all cursor-pointer group bg-background-light dark:bg-background-dark">
                        <input type="file" name="image" accept="image/*" class="hidden" id="image-input">
                        <span class="material-symbols-outlined text-3xl text-neutral-400 group-hover:text-primary">cloud_upload</span>
                        <p class="text-sm text-neutral-500">Klik untuk upload gambar baru</p>
                    </label>
                    @error('image')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>
            </form>
        </div>
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
                    fileName.textContent = 'File baru: ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
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
