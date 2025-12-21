<x-layouts.admin 
    title="Tambah Kuliner" 
    :header="'Tambah Kuliner Baru'" 
    :description="'Isi detail di bawah untuk menambahkan kuliner ke database SuRasa'"
    :breadcrumbs="[['label' => 'Kuliner', 'url' => route('admin.kuliners.index')], ['label' => 'Tambah Baru']]"
>
    <div class="max-w-5xl mx-auto">
        <form id="kuliner-form" action="{{ route('admin.kuliners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Info -->
                <div class="lg:col-span-2 flex flex-col gap-8">
                    
                    <!-- Basic Info Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">restaurant</span>
                            Informasi Utama
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Nama Kuliner <span class="text-red-500">*</span></span>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                           class="w-full px-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                                           placeholder="Contoh: Nasi Goreng Gila">
                                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </label>
                                
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Kategori <span class="text-red-500">*</span></span>
                                    <div class="relative" x-data="{ 
                                            open: false, 
                                            selectedId: '{{ old('category_id') }}', 
                                            selectedName: '{{ old('category_id') ? $categories->firstWhere('id', old('category_id'))->name : 'Pilih kategori' }}' 
                                        }">
                                        <input type="hidden" name="category_id" x-model="selectedId" required>
                                        
                                        <button type="button" 
                                                @click="open = !open" 
                                                @click.away="open = false"
                                                class="w-full px-4 py-3 text-left rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white flex items-center justify-between"
                                                :class="{'border-red-500': {{ $errors->has('category_id') ? 'true' : 'false' }}}">
                                            <span x-text="selectedName" :class="{'text-neutral-400': !selectedId}"></span>
                                            <span class="material-symbols-outlined text-neutral-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                                        </button>
        
                                        <div x-show="open" 
                                             style="display: none;"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                             class="absolute z-50 w-full mt-2 bg-surface-light dark:bg-surface-dark rounded-xl shadow-xl border border-neutral-100 dark:border-neutral-800 max-h-60 overflow-y-auto custom-scrollbar">
                                            
                                            <div class="p-1.5 space-y-1">
                                                @foreach($categories as $category)
                                                <button type="button" 
                                                        @click="selectedId = '{{ $category->id }}'; selectedName = '{{ $category->name }}'; open = false"
                                                        class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm font-medium flex items-center justify-between group hover:bg-neutral-50 dark:hover:bg-neutral-800"
                                                        :class="{'bg-primary/10 text-primary': selectedId == '{{ $category->id }}', 'text-neutral-600 dark:text-neutral-400': selectedId != '{{ $category->id }}'}">
                                                    <span>{{ $category->name }}</span>
                                                    <span x-show="selectedId == '{{ $category->id }}'" class="material-symbols-outlined text-[18px]">check</span>
                                                </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </label>
                            </div>
                            
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Deskripsi Lengkap <span class="text-red-500">*</span></span>
                                <textarea name="description" rows="6" required
                                          class="w-full p-4 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white resize-y leading-relaxed"
                                          placeholder="Jelaskan tentang kuliner ini, rasa, suasana, sejarah, dan keunikannya...">{{ old('description') }}</textarea>
                                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </label>
                        </div>
                    </div>

                    <!-- Location & Contact Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up delay-100">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                            Lokasi & Kontak
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Kota/Area <span class="text-red-500">*</span></span>
                                <input type="text" name="location" value="{{ old('location') }}" required
                                       class="w-full px-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                                       placeholder="Contoh: Surabaya Pusat">
                                @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </label>
                            
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Kontak / Telepon</span>
                                <input type="text" name="contact" value="{{ old('contact') }}"
                                       class="w-full px-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                                       placeholder="Contoh: 08123456789">
                                @error('contact')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </label>
                            
                            <label class="flex flex-col gap-2 md:col-span-2">
                                <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Alamat Lengkap</span>
                                <input type="text" name="address" value="{{ old('address') }}"
                                       class="w-full px-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                                       placeholder="Jl. Tunjungan No. 12, Surabaya">
                                @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Details & Media -->
                <div class="flex flex-col gap-8">
                    
                    <!-- Publishing Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up delay-200 sticky top-24">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6">Status Publikasi</h3>
                        
                        <div class="space-y-4 mb-8">
                            <label class="flex items-center justify-between p-3 rounded-xl border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer transition-colors">
                                <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Status Aktif</span>
                                <div class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                                </div>
                            </label>
                            
                            <label class="flex items-center justify-between p-3 rounded-xl border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer transition-colors">
                                <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Featured (Unggulan)</span>
                                <div class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                                </div>
                            </label>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit" class="w-full px-6 py-3.5 rounded-xl bg-primary text-neutral-900 font-bold hover:brightness-105 shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">publish</span>
                                Simpan Kuliner
                            </button>
                            <a href="{{ route('admin.kuliners.index') }}" class="w-full px-6 py-3.5 rounded-xl bg-transparent border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 font-bold hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-all text-center">
                                Batal
                            </a>
                        </div>
                    </div>

                    <!-- Details Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up delay-200">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">tune</span>
                            Detail Lainnya
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex flex-col gap-2">
                                    <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Min. Harga</span>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 font-medium text-xs">Rp</span>
                                        <input type="number" name="price_min" value="{{ old('price_min') }}" min="0"
                                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white"
                                               placeholder="0">
                                    </div>
                                    @error('price_min')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Max. Harga</span>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 font-medium text-xs">Rp</span>
                                        <input type="number" name="price_max" value="{{ old('price_max') }}" min="0"
                                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-neutral-900 dark:text-white"
                                               placeholder="0">
                                    </div>
                                    @error('price_max')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </label>
                            </div>

                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Jam Operasional</span>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 text-[20px]">schedule</span>
                                    <input type="text" name="open_hours" value="{{ old('open_hours') }}"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl bg-background-light dark:bg-background-dark border border-neutral-200 dark:border-neutral-700 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-neutral-400 text-neutral-900 dark:text-white"
                                           placeholder="e.g. 08:00 - 22:00">
                                </div>
                                @error('open_hours')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </label>
                        </div>
                    </div>

                    <!-- Media Card -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800 animate-fade-in-up delay-300">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">image</span>
                            Foto Utama
                        </h3>
                        
                        <!-- Image Preview -->
                        <div id="image-preview-container" class="hidden w-full mb-4">
                            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-md border-2 border-primary group">
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
                        <label id="upload-label" class="w-full border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-xl p-8 flex flex-col items-center justify-center gap-3 hover:border-primary hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-all cursor-pointer group bg-background-light dark:bg-background-dark">
                            <input type="file" name="image" accept="image/*" class="hidden" id="image-input">
                            <div class="bg-neutral-100 dark:bg-neutral-800 p-3 rounded-full group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl text-neutral-400 dark:text-neutral-500 group-hover:text-primary">add_photo_alternate</span>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-bold text-neutral-900 dark:text-white group-hover:text-primary transition-colors">Upload Foto</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">PNG, JPG (Max. 5MB)</p>
                            </div>
                        </label>
                        @error('image')<p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>@enderror
                    </div>

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
@endpush
</x-layouts.admin>
