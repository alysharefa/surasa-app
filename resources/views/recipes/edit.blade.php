<x-app-layout>
    <div class="layout-container flex w-full flex-col">
    <div class="px-4 sm:px-10 lg:px-40 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">

            <!-- Page Heading -->
            <div class="flex flex-wrap justify-between items-end gap-6 p-4 mb-6">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <h1 class="text-text-main dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Edit Resep</h1>
                    </div>
                    <p class="text-text-muted text-base font-normal leading-normal">Perbarui informasi resep Anda</p>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
            <div class="mx-4 mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form id="recipeForm" action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Desktop Submit Buttons -->
                <div class="hidden sm:flex justify-end gap-3 mb-6 px-4">
                    <a href="{{ route('recipes.show', $recipe->slug) }}" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-6 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main dark:text-white hover:bg-border-light dark:hover:bg-border-dark transition-colors text-sm font-bold leading-normal tracking-[0.015em]">
                        <span class="truncate">Batal</span>
                    </a>
                    <button type="submit" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-6 bg-primary hover:bg-yellow-400 transition-colors text-text-main text-sm font-bold leading-normal tracking-[0.015em]">
                        <span class="truncate">Simpan Perubahan</span>
                    </button>
                </div>
                
                <div class="flex flex-col lg:flex-row gap-8 px-4">
                    <!-- Left Column: Structured Data -->
                    <div class="flex-1 flex flex-col gap-8">
                        <!-- Recipe Basics -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 sm:p-8 rounded-lg shadow-sm">
                            <h3 class="text-xl font-bold mb-6 text-text-main dark:text-white">Informasi Dasar</h3>
                            <div class="space-y-6">
                                <label class="flex flex-col w-full">
                                    <span class="text-text-main dark:text-white text-base font-medium leading-normal pb-2">Judul Resep <span class="text-red-500">*</span></span>
                                    <input 
                                        type="text" 
                                        name="title" 
                                        value="{{ old('title', $recipe->title) }}"
                                        required
                                        class="form-input flex w-full min-w-0 resize-none overflow-hidden rounded-full text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark h-14 placeholder:text-text-muted px-6 text-lg font-normal leading-normal transition-shadow" 
                                        placeholder="Contoh: Rendang Daging Sapi Padang"
                                    />
                                </label>

                                <label class="flex flex-col w-full">
                                    <span class="text-text-main dark:text-white text-base font-medium leading-normal pb-2">Deskripsi / Cerita <span class="text-red-500">*</span></span>
                                    <textarea 
                                        name="description" 
                                        required
                                        class="form-input flex w-full min-w-0 resize-none overflow-hidden rounded-lg text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark min-h-36 placeholder:text-text-muted p-4 text-base font-normal leading-normal transition-shadow"
                                        placeholder="Ceritakan apa yang membuat resep ini spesial..."
                                    >{{ old('description', $recipe->description) }}</textarea>
                                </label>
                            </div>
                        </div>

                        <!-- Ingredients -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 sm:p-8 rounded-lg shadow-sm">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-text-main dark:text-white">Bahan-bahan <span class="text-red-500">*</span></h3>
                                <button type="button" onclick="openBulkModal()" class="text-sm font-bold text-primary hover:text-yellow-400 transition-colors">Bulk Add</button>
                            </div>
                            <div id="ingredientsList" class="space-y-3">
                                <!-- Ingredient rows will be added dynamically -->
                            </div>
                            <button type="button" onclick="addIngredient()" class="mt-6 flex items-center gap-2 text-text-main dark:text-white font-bold hover:opacity-70 transition-opacity">
                                <div class="size-6 rounded-full bg-primary flex items-center justify-center text-black">
                                    <span class="material-symbols-outlined text-[16px]">add</span>
                                </div>
                                Tambah Bahan
                            </button>
                            @error('ingredients')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            @error('ingredients.*')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Steps -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 sm:p-8 rounded-lg shadow-sm">
                            <h3 class="text-xl font-bold mb-6 text-text-main dark:text-white">Cara Membuat <span class="text-red-500">*</span></h3>
                            <div id="stepsList" class="space-y-6">
                                <!-- Steps will be added dynamically -->
                            </div>
                            <button type="button" onclick="addStep()" class="mt-6 flex items-center gap-2 text-text-main dark:text-white font-bold hover:opacity-70 transition-opacity">
                                <div class="size-6 rounded-full bg-primary flex items-center justify-center text-black">
                                    <span class="material-symbols-outlined text-[16px]">add</span>
                                </div>
                                Tambah Langkah
                            </button>
                            @error('steps')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            @error('steps.*')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tips -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 sm:p-8 rounded-lg shadow-sm">
                            <h3 class="text-xl font-bold mb-6 text-text-main dark:text-white">Tips & Catatan</h3>
                            <textarea 
                                name="tips" 
                                rows="4"
                                class="form-input flex w-full min-w-0 resize-y overflow-hidden rounded-lg text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-muted p-4 text-base font-normal leading-normal transition-shadow"
                                placeholder="Tips tambahan untuk hasil masakan terbaik... (opsional)"
                            >{{ old('tips', $recipe->tips) }}</textarea>
                        </div>
                    </div>

                    <!-- Right Column: Visuals & Metadata -->
                    <div class="w-full lg:w-[360px] flex flex-col gap-8 shrink-0">
                        <!-- Hero Image Upload -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-lg shadow-sm">
                            <h3 class="text-lg font-bold mb-4 text-text-main dark:text-white">Foto Resep</h3>
                            <div class="relative w-full aspect-[4/3] rounded-lg border-2 border-dashed border-border-dark/20 dark:border-border-light/20 bg-background-light dark:bg-background-dark flex flex-col items-center justify-center gap-3 cursor-pointer hover:bg-border-light/50 dark:hover:bg-border-dark/50 transition-colors group overflow-hidden" id="imageUploadContainer">
                                <input 
                                    type="file" 
                                    name="image" 
                                    id="recipeImage"
                                    accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    onchange="previewImage(this)"
                                />
                                @if($recipe->image)
                                <div id="imagePreview" class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $recipe->image) }}');"></div>
                                @else
                                <div id="imagePreview" class="hidden absolute inset-0 bg-cover bg-center"></div>
                                @endif
                                <div id="uploadPlaceholder" class="flex flex-col items-center text-center p-4 {{ $recipe->image ? 'hidden' : '' }}">
                                    <span class="material-symbols-outlined text-[48px] text-text-muted group-hover:text-primary transition-colors mb-2">cloud_upload</span>
                                    <p class="text-sm font-medium text-text-main dark:text-white">Drag & drop atau klik untuk ganti</p>
                                    <p class="text-xs text-text-muted mt-1">JPG, PNG, WEBP (Max 2MB)</p>
                                </div>
                                <!-- Success indicator -->
                                <div id="uploadSuccess" class="hidden absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 z-20">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    Gambar dipilih
                                </div>
                            </div>
                            <p id="imageFileName" class="text-xs text-text-muted mt-2 hidden"></p>
                            @error('image')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                        </div>

                        <!-- Details & Metadata -->
                        <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-lg shadow-sm space-y-6">
                            <h3 class="text-lg font-bold text-text-main dark:text-white">Detail Resep</h3>
                            
                            <!-- Times -->
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex flex-col">
                                    <span class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Waktu Persiapan</span>
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            name="prep_time" 
                                            value="{{ old('prep_time', $recipe->prep_time) }}"
                                            min="0"
                                            class="w-full rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark pl-4 pr-12 py-2 text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none" 
                                            placeholder="0"
                                        />
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-text-muted">menit</span>
                                    </div>
                                </label>
                                <label class="flex flex-col">
                                    <span class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Waktu Masak</span>
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            name="cooking_time" 
                                            value="{{ old('cooking_time', $recipe->cooking_time) }}"
                                            min="0"
                                            class="w-full rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark pl-4 pr-12 py-2 text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none" 
                                            placeholder="0"
                                        />
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-text-muted">menit</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Servings -->
                            <label class="flex flex-col">
                                <div class="flex justify-between items-baseline mb-2">
                                    <span class="text-xs font-bold text-text-muted uppercase tracking-wider">Porsi</span>
                                    <span id="servingsDisplay" class="text-sm font-bold text-primary">{{ $recipe->servings ?? 4 }} orang</span>
                                </div>
                                <input 
                                    type="range" 
                                    name="servings" 
                                    id="servingsRange"
                                    value="{{ old('servings', $recipe->servings ?? 4) }}"
                                    min="1" max="20"
                                    class="w-full h-2 bg-background-dark/10 dark:bg-white/10 rounded-lg appearance-none cursor-pointer accent-primary"
                                    oninput="document.getElementById('servingsDisplay').textContent = this.value + ' orang'"
                                />
                            </label>

                            <!-- Difficulty -->
                            <div class="flex flex-col gap-2">
                                <span class="text-xs font-bold text-text-muted uppercase tracking-wider">Tingkat Kesulitan</span>
                                <div class="flex rounded-full bg-background-light dark:bg-background-dark p-1 border border-border-light dark:border-border-dark">
                                    <label class="flex-1">
                                        <input type="radio" name="difficulty" value="mudah" class="hidden peer" {{ old('difficulty', $recipe->difficulty) == 'mudah' ? 'checked' : '' }}>
                                        <span class="block py-1.5 px-3 rounded-full text-xs font-bold text-center cursor-pointer peer-checked:bg-white dark:peer-checked:bg-surface-dark peer-checked:shadow-sm text-text-muted peer-checked:text-text-main dark:peer-checked:text-white transition-all">Mudah</span>
                                    </label>
                                    <label class="flex-1">
                                        <input type="radio" name="difficulty" value="sedang" class="hidden peer" {{ old('difficulty', $recipe->difficulty) == 'sedang' ? 'checked' : '' }}>
                                        <span class="block py-1.5 px-3 rounded-full text-xs font-bold text-center cursor-pointer peer-checked:bg-white dark:peer-checked:bg-surface-dark peer-checked:shadow-sm text-text-muted peer-checked:text-text-main dark:peer-checked:text-white transition-all">Sedang</span>
                                    </label>
                                    <label class="flex-1">
                                        <input type="radio" name="difficulty" value="sulit" class="hidden peer" {{ old('difficulty', $recipe->difficulty) == 'sulit' ? 'checked' : '' }}>
                                        <span class="block py-1.5 px-3 rounded-full text-xs font-bold text-center cursor-pointer peer-checked:bg-white dark:peer-checked:bg-surface-dark peer-checked:shadow-sm text-text-muted peer-checked:text-text-main dark:peer-checked:text-white transition-all">Sulit</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Nutrition Info -->
                            <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-border-light dark:border-border-dark">
                                <label class="flex flex-col">
                                    <span class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Kalori (kcal)</span>
                                    <input 
                                        type="number" 
                                        name="calories" 
                                        value="{{ old('calories', $recipe->calories) }}"
                                        min="0"
                                        class="w-full rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-4 py-2 text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none" 
                                        placeholder="0"
                                    />
                                </label>
                                <label class="flex flex-col">
                                    <span class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Protein (g)</span>
                                    <input 
                                        type="number" 
                                        name="protein" 
                                        value="{{ old('protein', $recipe->protein) }}"
                                        min="0"
                                        class="w-full rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-4 py-2 text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none" 
                                        placeholder="0"
                                    />
                                </label>
                                <label class="flex flex-col">
                                    <span class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Lemak (g)</span>
                                    <input 
                                        type="number" 
                                        name="fat" 
                                        value="{{ old('fat', $recipe->fat) }}"
                                        min="0"
                                        class="w-full rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-4 py-2 text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none" 
                                        placeholder="0"
                                    />
                                </label>
                                <label class="flex flex-col">
                                    <span class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1">Karbo (g)</span>
                                    <input 
                                        type="number" 
                                        name="carbs" 
                                        value="{{ old('carbs', $recipe->carbs) }}"
                                        min="0"
                                        class="w-full rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-4 py-2 text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none" 
                                        placeholder="0"
                                    />
                                </label>
                            </div>

                            <!-- Tags -->
                            <div class="flex flex-col gap-2">
                                <span class="text-xs font-bold text-text-muted uppercase tracking-wider">Tags</span>
                                <div id="tagsList" class="flex flex-wrap gap-2">
                                    <button type="button" onclick="openTagModal()" class="inline-flex items-center px-3 py-1 rounded-full bg-transparent border border-dashed border-text-muted text-text-muted hover:border-primary hover:text-primary transition-colors text-xs font-bold">
                                        + Tambah Tag
                                    </button>
                                </div>
                                <input type="hidden" name="tags" id="tagsData" value="">
                            </div>
                        </div>

                        <!-- Submit Buttons (Mobile) -->
                        <div class="sm:hidden bg-surface-light dark:bg-surface-dark p-6 rounded-lg shadow-sm space-y-4">
                            <button type="submit" class="w-full flex cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-6 bg-primary hover:bg-yellow-400 transition-colors text-text-main text-sm font-bold">
                                <span class="material-symbols-outlined mr-2">save</span>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('recipes.show', $recipe->slug) }}" class="w-full flex cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-6 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark text-text-main dark:text-white hover:bg-border-light dark:hover:bg-border-dark transition-colors text-sm font-bold">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Add Modal -->
<div id="bulkModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 w-full max-w-lg mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold">Tambah Bahan Secara Bulk</h3>
            <button type="button" onclick="closeBulkModal()" class="p-2 hover:bg-border-light rounded-full">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <p class="text-sm text-text-muted mb-4">Tulis satu bahan per baris</p>
        <textarea id="bulkInput" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark p-4 min-h-[200px]" placeholder="2 cups beras basmati&#10;500g daging sapi&#10;3 siung bawang putih"></textarea>
        <div class="flex justify-end gap-3 mt-4">
            <button type="button" onclick="closeBulkModal()" class="px-4 py-2 rounded-full border border-border-light hover:bg-border-light font-bold text-sm">Batal</button>
            <button type="button" onclick="saveBulkIngredients()" class="px-4 py-2 rounded-full bg-primary text-text-main font-bold text-sm">Tambahkan</button>
        </div>
    </div>
</div>

<!-- Tag Modal (Reused) -->
<div id="tagModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg p-6 w-full max-w-sm mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold">Tambah Tag</h3>
            <button type="button" onclick="closeTagModal()" class="p-2 hover:bg-border-light rounded-full">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <input type="text" id="newTagInput" class="w-full rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-4 py-2" placeholder="Contoh: Vegetarian" onkeypress="if(event.key==='Enter'){event.preventDefault();saveTag();}">
        <div class="flex justify-end gap-3 mt-4">
            <button type="button" onclick="closeTagModal()" class="px-4 py-2 rounded-full border border-border-light hover:bg-border-light font-bold text-sm">Batal</button>
            <button type="button" onclick="saveTag()" class="px-4 py-2 rounded-full bg-primary text-text-main font-bold text-sm">Tambah</button>
        </div>
    </div>
</div>

<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
let ingredientId = 0;
let stepId = 0;
let tags = [];

// Initialize Data
document.addEventListener('DOMContentLoaded', function() {
    // Ingredients
    @if(old('ingredients'))
        @foreach(old('ingredients') as $ing)
            addIngredient('{{ addslashes($ing) }}');
        @endforeach
    @elseif(is_array($recipe->ingredients))
        @foreach($recipe->ingredients as $ing)
            addIngredient('{{ addslashes($ing) }}');
        @endforeach
    @else
        // Fallback or empty
        addIngredient();
    @endif
    
    // Steps
    @if(old('steps'))
        @foreach(old('steps') as $step)
            addStep('{{ addslashes($step) }}');
        @endforeach
    @elseif(is_array($recipe->steps))
        @foreach($recipe->steps as $step)
            addStep('{{ addslashes($step) }}');
        @endforeach
    @else
        addStep();
    @endif
    
    document.getElementById('servingsDisplay').textContent = document.getElementById('servingsRange').value + ' orang';

    // Init Sortable for Ingredients
    new Sortable(document.getElementById('ingredientsList'), {
        handle: '.cursor-move',
        animation: 150,
        ghostClass: 'bg-primary/10'
    });

    // Init Sortable for Steps
    new Sortable(document.getElementById('stepsList'), {
        handle: '.step-num',
        animation: 150,
        ghostClass: 'opacity-50',
        onEnd: function() {
            renumberSteps();
        }
    });
});

// Reusing same functions as create.blade.php
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const successIndicator = document.getElementById('uploadSuccess');
    const fileNameDisplay = document.getElementById('imageFileName');
    const container = document.getElementById('imageUploadContainer');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.style.backgroundImage = 'url(' + e.target.result + ')';
            preview.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
            if(successIndicator) successIndicator.classList.remove('hidden');
            container.classList.add('border-green-500');
            container.classList.remove('border-border-dark/20', 'dark:border-border-light/20');

            const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
            fileNameDisplay.textContent = 'File: ' + file.name + ' (' + fileSizeMB + ' MB)';
            fileNameDisplay.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Ingredients
function addIngredient(value = '') {
    ingredientId++;
    const container = document.getElementById('ingredientsList');
    const row = document.createElement('div');
    row.className = 'flex gap-3 items-center group';
    row.id = 'ing-' + ingredientId;
    row.innerHTML = `
        <span class="material-symbols-outlined text-text-muted cursor-move opacity-0 group-hover:opacity-100 transition-opacity">drag_indicator</span>
        <input type="text" name="ingredients[]" class="ing-input flex-1 rounded-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-4 py-2 text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none" placeholder="Contoh: 2 cups beras basmati" value="${escapeHtml(value)}">
        <button type="button" class="p-2 text-text-muted hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100" onclick="removeIngredient(${ingredientId})">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    `;
    container.appendChild(row);
}

function removeIngredient(id) {
    const container = document.getElementById('ingredientsList');
    if (container.children.length > 1) {
        document.getElementById('ing-' + id)?.remove();
    }
}

// Steps
function addStep(value = '') {
    stepId++;
    const container = document.getElementById('stepsList');
    const stepNum = container.children.length + 1;
    const row = document.createElement('div');
    row.className = 'flex gap-4 group';
    row.id = 'step-' + stepId;
    row.innerHTML = `
        <div class="flex flex-col items-center gap-1">
            <div class="size-8 rounded-full ${stepNum === 1 ? 'bg-primary text-text-main' : 'bg-surface-light dark:bg-surface-dark border-2 border-border-light dark:border-border-dark text-text-muted'} flex items-center justify-center font-bold shrink-0 step-num">${stepNum}</div>
            <div class="w-0.5 grow bg-border-light dark:bg-border-dark my-1 step-line"></div>
        </div>
        <div class="flex-1 pb-4 relative">
            <textarea name="steps[]" class="step-input w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark p-4 text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none min-h-[100px] resize-y" placeholder="Jelaskan langkah ini...">${escapeHtml(value)}</textarea>
            <button type="button" class="absolute top-2 right-2 p-1 text-text-muted hover:text-red-500 opacity-0 group-hover:opacity-100" onclick="removeStep(${stepId})">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
    `;
    container.appendChild(row);
    renumberSteps();
}

function removeStep(id) {
    const container = document.getElementById('stepsList');
    if (container.children.length > 1) {
        document.getElementById('step-' + id)?.remove();
        renumberSteps();
    }
}

function renumberSteps() {
    const steps = document.querySelectorAll('#stepsList > div');
    steps.forEach((step, i) => {
        const num = step.querySelector('.step-num');
        const line = step.querySelector('.step-line');
        if (num) {
            num.textContent = i + 1;
            num.className = 'size-8 rounded-full ' + (i === 0 ? 'bg-primary text-text-main' : 'bg-surface-light dark:bg-surface-dark border-2 border-border-light dark:border-border-dark text-text-muted') + ' flex items-center justify-center font-bold shrink-0 step-num';
        }
        if (line) line.style.display = i === steps.length - 1 ? 'none' : 'block';
    });
}

// Bulk & Tags helpers same as create...
function openBulkModal() { document.getElementById('bulkModal').classList.remove('hidden'); }
function closeBulkModal() { document.getElementById('bulkModal').classList.add('hidden'); document.getElementById('bulkInput').value = ''; }
function saveBulkIngredients() {
    document.getElementById('bulkInput').value.split('\n').filter(l => l.trim()).forEach(l => addIngredient(l.trim()));
    closeBulkModal();
}
function openTagModal() { document.getElementById('tagModal').classList.remove('hidden'); document.getElementById('newTagInput').focus(); }
function closeTagModal() { document.getElementById('tagModal').classList.add('hidden'); document.getElementById('newTagInput').value = ''; }
function quickAddTag(t) { if (!tags.includes(t)) { tags.push(t); renderTags(); } closeTagModal(); }
function saveTag() {
    const t = document.getElementById('newTagInput').value.trim();
    if (t && !tags.includes(t)) { tags.push(t); renderTags(); }
    closeTagModal();
}
function removeTag(t) { tags = tags.filter(x => x !== t); renderTags(); }
function renderTags() {
    const c = document.getElementById('tagsList');
    c.innerHTML = tags.map(t => `<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-primary/20 text-text-main dark:text-primary text-xs font-bold">${escapeHtml(t)}<button type="button" onclick="removeTag('${escapeHtml(t)}')" class="hover:text-red-500"><span class="material-symbols-outlined text-[14px]">close</span></button></span>`).join('') + `<button type="button" onclick="openTagModal()" class="inline-flex items-center px-3 py-1 rounded-full bg-transparent border border-dashed border-text-muted text-text-muted hover:border-primary hover:text-primary transition-colors text-xs font-bold">+ Tambah Tag</button>`;
    document.getElementById('tagsData').value = tags.join(',');
}
function escapeHtml(t) { const d = document.createElement('div'); d.textContent = t; return d.innerHTML; }

// Validate
document.getElementById('recipeForm').addEventListener('submit', function(e) {
    // Basic validation similar to create
    // ...
    // Show loading state
    const btn = e.submitter;
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin mr-2">⏳</span> Menyimpan...';
    }
    return true;
});
</script>
</x-app-layout>