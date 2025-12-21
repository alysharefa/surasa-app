<x-app-layout>
    <div class="bg-background-light dark:bg-background-dark min-h-screen pb-20">
        <form id="recipeForm" action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- 1. Hero Image Upload (Full Width) -->
            <div class="relative w-full h-[250px] md:h-[350px] bg-stone-200 dark:bg-stone-800 group cursor-pointer overflow-hidden">
                <input 
                    type="file" 
                    name="image" 
                    id="recipeImage"
                    accept="image/*"
                    class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer"
                    onchange="previewImage(this)"
                />
                
                <!-- Placeholder State -->
                <div id="uploadPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center text-stone-500 dark:text-stone-400 transition-all group-hover:bg-black/10 dark:group-hover:bg-black/20">
                    <div class="bg-surface-light dark:bg-surface-dark p-3 rounded-full shadow-md mb-2 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl text-primary">add_a_photo</span>
                    </div>
                    <p class="font-bold text-base">Pasang Foto</p>
                </div>

                <!-- Preview State -->
                <div id="imagePreview" class="hidden absolute inset-0 bg-cover bg-center transition-transform duration-700"></div>
                
                <!-- Overlay Hint -->
                <div class="absolute bottom-0 left-0 w-full p-2 bg-gradient-to-t from-black/60 to-transparent text-white opacity-0 group-hover:opacity-100 transition-opacity z-10 pointer-events-none">
                    <p class="text-center font-bold text-xs">Ubah Foto</p>
                </div>
            </div>

            <!-- Main Content Container -->
            <div class="max-w-[1000px] mx-auto px-4 -mt-16 relative z-30 mb-12">
                <div class="bg-surface-light dark:bg-surface-dark rounded-3xl shadow-lg border border-border-light dark:border-border-dark p-6 md:p-8">
                    
                    <!-- 2. Header Inputs (Title, Description, Meta) -->
                    <div class="flex flex-col gap-4 mb-8 text-center items-center">
                        <!-- Difficulty Badge Select -->
                        <div class="flex bg-background-light dark:bg-background-dark p-1 rounded-full border border-border-light dark:border-border-dark scale-90 origin-bottom">
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty" value="mudah" class="hidden peer" checked>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-text-muted peer-checked:bg-green-100 peer-checked:text-green-800 dark:peer-checked:bg-green-900/30 dark:peer-checked:text-green-400 transition-all block">Mudah</span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty" value="sedang" class="hidden peer">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-text-muted peer-checked:bg-yellow-100 peer-checked:text-yellow-800 dark:peer-checked:bg-yellow-900/30 dark:peer-checked:text-yellow-400 transition-all block">Sedang</span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty" value="sulit" class="hidden peer">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-text-muted peer-checked:bg-red-100 peer-checked:text-red-800 dark:peer-checked:bg-red-900/30 dark:peer-checked:text-red-400 transition-all block">Sulit</span>
                            </label>
                        </div>

                        <!-- Title Input -->
                        <input 
                            type="text" 
                            name="title" 
                            placeholder="Judul Resep..." 
                            class="w-full text-center text-3xl md:text-4xl font-black bg-transparent border-none p-0 placeholder-stone-300 dark:placeholder-stone-700 text-text-main dark:text-white focus:ring-0 leading-tight"
                            required
                        />

                        <!-- Description Input -->
                        <textarea 
                            name="description" 
                            rows="2"
                            placeholder="Ceritakan sedikit tentang resep ini..."
                            class="w-full max-w-2xl text-center text-base md:text-lg text-text-sec-light dark:text-text-sec-dark bg-transparent border-none p-0 placeholder-stone-300 dark:placeholder-stone-700 focus:ring-0 resize-none leading-relaxed"
                            required
                        ></textarea>

                        <!-- Meta Inputs (Time & Servings) -->
                        <div class="flex flex-wrap justify-center gap-4 py-4 border-t border-border-light dark:border-border-dark w-full max-w-3xl mt-4">
                            <div class="flex flex-col items-center gap-1 px-4 py-3 bg-background-light dark:bg-background-dark rounded-full min-w-[90px]">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Persiapan</span>
                                <div class="flex items-baseline gap-1">
                                    <input type="number" name="prep_time" placeholder="0" class="w-12 text-center bg-transparent border-none focus:ring-0 p-0 text-xl font-bold text-text-main dark:text-white" min="0">
                                    <span class="text-xs font-medium text-text-muted">m</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-center gap-1 px-4 py-3 bg-background-light dark:bg-background-dark rounded-full min-w-[90px]">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Masak</span>
                                <div class="flex items-baseline gap-1">
                                    <input type="number" name="cooking_time" placeholder="0" class="w-12 text-center bg-transparent border-none focus:ring-0 p-0 text-xl font-bold text-text-main dark:text-white" min="0">
                                    <span class="text-xs font-medium text-text-muted">m</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-center gap-1 px-4 py-3 bg-background-light dark:bg-background-dark rounded-full min-w-[90px]">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Porsi</span>
                                <div class="flex items-baseline gap-1">
                                    <input type="number" name="servings" value="2" class="w-12 text-center bg-transparent border-none focus:ring-0 p-0 text-xl font-bold text-text-main dark:text-white" min="1">
                                    <span class="text-xs font-medium text-text-muted">org</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nutrition Info -->
                        <div class="flex flex-wrap justify-center gap-4 pb-4 border-b border-border-light dark:border-border-dark w-full max-w-3xl mb-4">
                            <div class="flex flex-col items-center gap-1 px-4 py-3 bg-background-light dark:bg-background-dark rounded-full min-w-[90px]">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Kalori</span>
                                <div class="flex items-baseline gap-1">
                                    <input type="number" name="calories" placeholder="0" class="w-16 text-center bg-transparent border-none focus:ring-0 p-0 text-xl font-bold text-text-main dark:text-white" min="0">
                                    <span class="text-xs font-medium text-text-muted">kcal</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-center gap-1 px-4 py-3 bg-background-light dark:bg-background-dark rounded-full min-w-[90px]">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Protein</span>
                                <div class="flex items-baseline gap-1">
                                    <input type="number" name="protein" placeholder="0" class="w-12 text-center bg-transparent border-none focus:ring-0 p-0 text-xl font-bold text-text-main dark:text-white" min="0">
                                    <span class="text-xs font-medium text-text-muted">g</span>
                                </div>
                            </div>
                             <div class="flex flex-col items-center gap-1 px-4 py-3 bg-background-light dark:bg-background-dark rounded-full min-w-[90px]">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Lemak</span>
                                <div class="flex items-baseline gap-1">
                                    <input type="number" name="fat" placeholder="0" class="w-12 text-center bg-transparent border-none focus:ring-0 p-0 text-xl font-bold text-text-main dark:text-white" min="0">
                                    <span class="text-xs font-medium text-text-muted">g</span>
                                </div>
                            </div>
                             <div class="flex flex-col items-center gap-1 px-4 py-3 bg-background-light dark:bg-background-dark rounded-full min-w-[90px]">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-text-muted">Karbo</span>
                                <div class="flex items-baseline gap-1">
                                    <input type="number" name="carbs" placeholder="0" class="w-12 text-center bg-transparent border-none focus:ring-0 p-0 text-xl font-bold text-text-main dark:text-white" min="0">
                                    <span class="text-xs font-medium text-text-muted">g</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tags & Category -->
                        <div class="flex flex-col md:flex-row items-center gap-4 w-full justify-center">
                            <!-- Category Selection (Compact) -->
                            <div class="relative">
                                <input type="hidden" name="kuliner_id" id="selectedCategoryInput" required>
                                <button type="button" onclick="document.getElementById('categoryDropdown').classList.toggle('hidden')" class="flex items-center gap-2 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-full px-4 py-2 hover:border-primary transition-colors text-sm font-bold group">
                                    <span class="material-symbols-outlined text-text-muted group-hover:text-primary text-[18px]">restaurant_menu</span>
                                    <span id="selectedCategoryLabel" class="text-text-main dark:text-white">Pilih Kategori</span>
                                    <span class="material-symbols-outlined text-text-muted text-[16px]">expand_more</span>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="categoryDropdown" class="hidden absolute top-full left-1/2 -translate-x-1/2 mt-2 w-56 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-xl shadow-xl z-50 max-h-56 overflow-y-auto p-1">
                                    @foreach($kuliners as $kuliner)
                                    <button type="button" onclick="selectCategory('{{ $kuliner->id }}', '{{ $kuliner->name }}')" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-background-light dark:hover:bg-background-dark text-left transition-colors">
                                        <div class="size-6 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-[10px]">
                                            {{ substr($kuliner->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-bold text-text-main dark:text-white">{{ $kuliner->name }}</span>
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Tags Trigger -->
                            <button type="button" onclick="openTagModal()" class="text-xs font-bold text-primary hover:text-primary-dark transition-colors flex items-center gap-1 border border-dashed border-primary/30 px-3 py-2 rounded-full hover:bg-primary/5">
                                <span class="material-symbols-outlined text-[16px]">label</span> Tambah Tag
                            </button>
                        </div>
                        
                        <div id="tagsList" class="flex flex-wrap justify-center gap-2 mt-[-5px]"></div>
                        <input type="hidden" name="tags" id="tagsData">
                    </div>

                    <!-- 3. Dynamic Lists (Ingredients & Steps) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-8">
                        <!-- Left: Ingredients -->
                        <div class="lg:col-span-4 flex flex-col gap-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-black text-text-main dark:text-white">Bahan-bahan</h3>
                                <button type="button" onclick="openBulkModal()" class="text-xs font-bold text-primary hover:underline">Bulk Add</button>
                            </div>
                            
                            <div class="bg-background-light dark:bg-background-dark rounded-2xl p-5 border border-border-light dark:border-border-dark">
                                <div id="ingredientsList" class="space-y-1">
                                    <!-- Items added via JS -->
                                </div>
                                <button type="button" onclick="addIngredient()" class="mt-4 w-full py-2 border-2 border-dashed border-stone-300 dark:border-stone-700 rounded-xl text-stone-500 text-sm font-bold hover:border-primary hover:text-primary transition-colors flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[18px]">add</span> Tambah Bahan
                                </button>
                            </div>
                        </div>

                        <!-- Right: Steps -->
                        <div class="lg:col-span-8 flex flex-col gap-6">
                            <h3 class="text-xl font-black text-text-main dark:text-white">Instruksi Masak</h3>
                            <div id="stepsList" class="space-y-3">
                                <!-- Items added via JS -->
                            </div>
                            <button type="button" onclick="addStep()" class="w-full py-3 border-2 border-dashed border-stone-300 dark:border-stone-700 rounded-2xl text-stone-500 font-bold hover:border-primary hover:text-primary transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">add_circle</span> Tambah Langkah Baru
                            </button>
                            
                            <!-- Tips Section -->
                            <div class="mt-4 p-5 bg-yellow-50 dark:bg-yellow-900/10 rounded-2xl border border-yellow-200 dark:border-yellow-900/30">
                                <h4 class="font-bold text-yellow-800 dark:text-yellow-200 mb-2 flex items-center gap-2 text-sm">
                                    <span class="material-symbols-outlined text-[18px]">lightbulb</span> Tips Chef
                                </h4>
                                <textarea name="tips" rows="2" class="w-full bg-transparent border-none p-0 placeholder-yellow-800/50 dark:placeholder-yellow-200/50 text-yellow-900 dark:text-yellow-100 focus:ring-0 resize-none text-sm" placeholder="Tulis tips rahasia agar masakan makin lezat..."></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Floating Action Bar -->
            <div class="fixed bottom-0 left-0 w-full bg-surface-light/90 dark:bg-surface-dark/90 backdrop-blur-md border-t border-border-light dark:border-border-dark p-4 z-40">
                <div class="max-w-[1000px] mx-auto flex items-center justify-between">
                    <span class="text-sm font-bold text-text-muted hidden md:block">Pastikan data sudah benar sebelum publikasi.</span>
                    <div class="flex items-center gap-3 ml-auto">
                        <a href="{{ route('recipes.my') }}" class="px-6 py-3 rounded-full font-bold text-text-sec-light dark:text-text-sec-dark hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors text-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-full bg-primary text-black font-black text-base shadow-lg hover:shadow-primary/30 hover:-translate-y-1 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined">publish</span>
                            Publikasikan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modals (Bulk & Tags) -->
    <div id="bulkModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-8 w-full max-w-lg mx-4 shadow-2xl animate-fade-in-up">
            <h3 class="text-xl font-black mb-2">Paste Bahan</h3>
            <p class="text-sm text-text-muted mb-4">Salin dan tempel daftar bahanmu di sini. Satu baris per bahan.</p>
            <textarea id="bulkInput" class="w-full rounded-xl border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark p-4 min-h-[200px] focus:ring-primary focus:border-primary" placeholder="Contoh:&#10;500g Tepung terigu&#10;2 butir Telur&#10;1 sdt Garam"></textarea>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeBulkModal()" class="px-6 py-2 rounded-full font-bold hover:bg-stone-100 dark:hover:bg-stone-800">Batal</button>
                <button type="button" onclick="saveBulkIngredients()" class="px-6 py-2 rounded-full bg-primary text-black font-bold">Tambahkan</button>
            </div>
        </div>
    </div>

    <div id="tagModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-8 w-full max-w-sm mx-4 shadow-2xl animate-fade-in-up">
            <h3 class="text-xl font-black mb-4">Tambah Tag</h3>
            <input type="text" id="newTagInput" class="w-full rounded-xl border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-4 py-3 focus:ring-primary focus:border-primary" placeholder="Contoh: Pedas, Sarapan..." onkeypress="if(event.key==='Enter'){event.preventDefault();saveTag();}">
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeTagModal()" class="px-6 py-2 rounded-full font-bold hover:bg-stone-100 dark:hover:bg-stone-800">Batal</button>
                <button type="button" onclick="saveTag()" class="px-6 py-2 rounded-full bg-primary text-black font-bold">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        let ingredientId = 0;
        let stepId = 0;
        let tags = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Init empty rows
            addIngredient();
            addIngredient();
            addIngredient();
            addStep();
            addStep();

            // Sortable
            new Sortable(document.getElementById('ingredientsList'), { handle: '.cursor-move', animation: 150, ghostClass: 'bg-primary/10' });
            new Sortable(document.getElementById('stepsList'), { handle: '.step-handle', animation: 150, onEnd: renumberSteps });
        });

        // Image Preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.classList.remove('hidden');
                    document.getElementById('uploadPlaceholder').classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Ingredient Logic
        function addIngredient(val = '') {
            ingredientId++;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 group';
            div.id = `ing-${ingredientId}`;
            div.innerHTML = `
                <span class="material-symbols-outlined text-stone-300 cursor-move hover:text-stone-500 text-[20px]">drag_indicator</span>
                <input type="text" name="ingredients[]" value="${escapeHtml(val)}" class="flex-1 bg-transparent border-b border-stone-200 dark:border-stone-700 py-1.5 focus:border-primary focus:ring-0 transition-colors text-sm" placeholder="Bahan...">
                <button type="button" onclick="document.getElementById('ing-${ingredientId}').remove()" class="text-stone-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"><span class="material-symbols-outlined text-[18px]">close</span></button>
            `;
            document.getElementById('ingredientsList').appendChild(div);
        }

        // Step Logic
        function addStep(val = '') {
            stepId++;
            const div = document.createElement('div');
            div.className = 'flex gap-4 group';
            div.id = `step-${stepId}`;
            div.innerHTML = `
                <div class="flex flex-col items-center gap-2">
                    <div class="step-handle size-8 rounded-full bg-surface-light dark:bg-surface-dark border-2 border-stone-200 dark:border-stone-700 flex items-center justify-center font-bold text-sm text-stone-400 cursor-move hover:border-primary hover:text-primary transition-colors step-num"></div>
                    <div class="w-0.5 grow bg-stone-200 dark:border-stone-700"></div>
                </div>
                <div class="flex-1 pb-3">
                    <textarea name="steps[]" rows="2" class="w-full rounded-xl border-stone-200 dark:border-stone-700 bg-background-light dark:bg-background-dark p-3 focus:ring-primary focus:border-primary resize-y text-sm" placeholder="Jelaskan langkah ini secara detail...">${escapeHtml(val)}</textarea>
                    <div class="flex justify-end mt-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button type="button" onclick="removeStep(${stepId})" class="text-[10px] font-bold text-red-500 hover:underline">Hapus Langkah</button>
                    </div>
                </div>
            `;
            document.getElementById('stepsList').appendChild(div);
            renumberSteps();
        }

        function removeStep(id) {
            const list = document.getElementById('stepsList');
            if(list.children.length > 1) {
                document.getElementById(`step-${id}`).remove();
                renumberSteps();
            }
        }

        function renumberSteps() {
            document.querySelectorAll('#stepsList .step-num').forEach((el, i) => el.innerText = i + 1);
        }

        // Modals & Tags
        function openBulkModal() { document.getElementById('bulkModal').classList.remove('hidden'); }
        function closeBulkModal() { document.getElementById('bulkModal').classList.add('hidden'); }
        function saveBulkIngredients() {
            const text = document.getElementById('bulkInput').value;
            text.split('\n').forEach(line => { if(line.trim()) addIngredient(line.trim()); });
            closeBulkModal();
            document.getElementById('bulkInput').value = '';
        }

        function openTagModal() { document.getElementById('tagModal').classList.remove('hidden'); document.getElementById('newTagInput').focus(); }
        function closeTagModal() { document.getElementById('tagModal').classList.add('hidden'); }
        function saveTag() {
            const val = document.getElementById('newTagInput').value.trim();
            if(val && !tags.includes(val)) {
                tags.push(val);
                renderTags();
            }
            closeTagModal();
            document.getElementById('newTagInput').value = '';
        }
        function removeTag(t) { tags = tags.filter(x => x !== t); renderTags(); }
        function renderTags() {
            const html = tags.map(t => `<span class="px-3 py-1 bg-primary/20 text-primary-dark rounded-full text-xs font-bold flex items-center gap-1">${escapeHtml(t)} <button type="button" onclick="removeTag('${escapeHtml(t)}')" class="hover:text-red-500">×</button></span>`).join('');
            document.getElementById('tagsList').innerHTML = html;
            // Note: You need to implement tag saving in backend if you want to keep them
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        // Category Selection
        function selectCategory(id, name) {
            document.getElementById('selectedCategoryInput').value = id;
            document.getElementById('selectedCategoryLabel').innerText = name;
            document.getElementById('selectedCategoryLabel').classList.add('text-primary');
            document.getElementById('categoryDropdown').classList.add('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('categoryDropdown');
            const button = dropdown.previousElementSibling;
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>