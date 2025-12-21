<x-layouts.admin 
    title="Edit Kuliner" 
    :header="'Edit Kuliner'" 
    :description="'Perbarui informasi kuliner'"
    :breadcrumbs="[['label' => 'Kuliner', 'url' => route('admin.kuliners.index')], ['label' => 'Edit']]"
>
    <!-- Actions -->
    <div class="flex justify-end gap-3 mb-8">
        <a href="{{ route('admin.kuliners.index') }}" class="px-6 py-3 rounded-lg bg-transparent border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white font-medium hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all">
            Batal
        </a>
        <button type="submit" form="kuliner-form" class="px-6 py-3 rounded-lg bg-primary text-neutral-900 font-bold hover:bg-primary-dark shadow-lg shadow-yellow-200/50 dark:shadow-none transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">save</span>
            Update Kuliner
        </button>
    </div>

    <!-- Form Card -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 md:p-10 shadow-sm border border-neutral-100 dark:border-neutral-800">
        <form id="kuliner-form" action="{{ route('admin.kuliners.update', $kuliner) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Basic Info -->
            <div class="flex flex-col gap-6">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span> Informasi Dasar
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Nama Kuliner *</span>
                        <input type="text" name="name" value="{{ old('name', $kuliner->name) }}" required
                               class="w-full h-14 px-5 rounded-lg bg-background-light dark:bg-background-dark border {{ $errors->has('name') ? 'border-red-500' : 'border-neutral-200 dark:border-neutral-700' }} focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                        @error('name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Kategori *</span>
                        <div class="relative" x-data="{ 
                                open: false, 
                                selectedId: '{{ old('category_id', $kuliner->category_id) }}', 
                                selectedName: '{{ $categories->firstWhere('id', old('category_id', $kuliner->category_id))->name }}' 
                            }">
                                <input type="hidden" name="category_id" x-model="selectedId" required>
                                
                                <button type="button" 
                                        @click="open = !open" 
                                        @click.away="open = false"
                                        class="w-full h-14 px-5 pr-10 rounded-lg text-left bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white flex items-center justify-between"
                                        :class="{'border-red-500': {{ $errors->has('category_id') ? 'true' : 'false' }}}">
                                    <span x-text="selectedName" :class="{'text-neutral-400': !selectedId}"></span>
                                    <span class="material-symbols-outlined text-neutral-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                                </button>

                                <div x-show="open" 
                                     style="display: none;"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                     class="absolute z-50 w-full mt-2 bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl border border-neutral-100 dark:border-neutral-800 max-h-60 overflow-y-auto custom-scrollbar">
                                    
                                    <div class="p-1">
                                        @foreach($categories as $category)
                                        <button type="button" 
                                                @click="selectedId = '{{ $category->id }}'; selectedName = '{{ $category->name }}'; open = false"
                                                class="w-full text-left px-4 py-3 rounded-lg transition-colors text-sm font-medium flex items-center justify-between group hover:bg-neutral-50 dark:hover:bg-neutral-800"
                                                :class="{'bg-primary/10 text-primary': selectedId == '{{ $category->id }}', 'text-neutral-600 dark:text-neutral-400': selectedId != '{{ $category->id }}'}">
                                            <span>{{ $category->name }}</span>
                                            <span x-show="selectedId == '{{ $category->id }}'" class="material-symbols-outlined text-[18px]">check</span>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                    </label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Lokasi *</span>
                        <input type="text" name="location" value="{{ old('location', $kuliner->location) }}" required
                               class="w-full h-14 px-5 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                        @error('location')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Alamat Lengkap</span>
                        <input type="text" name="address" value="{{ old('address', $kuliner->address) }}"
                               class="w-full h-14 px-5 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                        @error('address')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Harga Minimum</span>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-neutral-500 font-medium">Rp</span>
                            <input type="number" name="price_min" value="{{ old('price_min', $kuliner->price_min) }}" min="0"
                                   class="w-full h-14 pl-12 pr-5 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                        </div>
                        @error('price_min')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Harga Maksimum</span>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-neutral-500 font-medium">Rp</span>
                            <input type="number" name="price_max" value="{{ old('price_max', $kuliner->price_max) }}" min="0"
                                   class="w-full h-14 pl-12 pr-5 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                        </div>
                        @error('price_max')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Jam Operasional</span>
                        <input type="text" name="open_hours" value="{{ old('open_hours', $kuliner->open_hours) }}"
                               class="w-full h-14 px-5 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                               placeholder="08:00 - 22:00">
                        @error('open_hours')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </label>
                </div>
                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Kontak</span>
                    <input type="text" name="contact" value="{{ old('contact', $kuliner->contact) }}"
                           class="w-full h-14 px-5 rounded-full bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white">
                    @error('contact')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </label>
            </div>

            <hr class="border-neutral-200 dark:border-neutral-700">

            <!-- Section 2: Details -->
            <div class="flex flex-col gap-6">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span> Deskripsi
                </h3>
                <label class="flex flex-col gap-2">
                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Deskripsi *</span>
                    <textarea name="description" rows="5" required
                              class="w-full p-5 rounded-lg bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white resize-y">{{ old('description', $kuliner->description) }}</textarea>
                </label>
            </div>

            <hr class="border-neutral-200 dark:border-neutral-700">

            <!-- Section 3: Media -->
            <div class="flex flex-col gap-6">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">imagesmode</span> Gambar
                </h3>
                
                @if($kuliner->image)
                <div id="current-image-container" class="flex items-start gap-4 p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <div class="w-32 h-32 rounded-xl overflow-hidden bg-neutral-100 dark:bg-neutral-800 shadow-md">
                        <img src="{{ asset('storage/' . $kuliner->image) }}" alt="{{ $kuliner->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="text-sm font-bold text-neutral-700 dark:text-neutral-300 flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-500 text-[18px]">check_circle</span>
                            Gambar Saat Ini
                        </p>
                        <p class="text-xs text-neutral-500">Upload gambar baru untuk mengganti</p>
                    </div>
                </div>
                @endif

                <!-- New Image Preview Container -->
                <div id="image-preview-container" class="hidden w-full">
                    <div class="relative inline-block">
                        <img id="image-preview" src="" alt="Preview" class="max-w-xs h-auto rounded-xl shadow-lg border-2 border-primary">
                        <button type="button" id="remove-image" class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>
                    <p id="file-name" class="mt-3 text-sm text-neutral-600 dark:text-neutral-400"></p>
                </div>

                <label id="upload-label" class="w-full border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-lg p-10 flex flex-col items-center justify-center gap-4 hover:border-primary hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-all cursor-pointer group bg-background-light dark:bg-background-dark">
                    <input type="file" name="image" accept="image/*" class="hidden" id="image-input">
                    <div class="bg-neutral-100 dark:bg-neutral-800 p-4 rounded-full group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl text-neutral-400 dark:text-neutral-500 group-hover:text-primary">cloud_upload</span>
                    </div>
                    <div class="text-center">
                        <p class="text-base font-medium text-neutral-900 dark:text-white">Klik untuk upload gambar baru</p>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">PNG, JPG atau GIF (max. 5MB)</p>
                    </div>
                </label>
                @error('image')<p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>@enderror
            </div>

            <hr class="border-neutral-200 dark:border-neutral-700">

            <!-- Section 4: Status -->
            <div class="flex flex-col gap-6">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">toggle_on</span> Status
                </h3>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $kuliner->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-neutral-300 text-primary focus:ring-primary">
                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $kuliner->is_featured) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-neutral-300 text-primary focus:ring-primary">
                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Featured</span>
                    </label>
                </div>
            </div>
        </form>
    </div>

@push('scripts')
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
@endpush

</x-layouts.admin>
