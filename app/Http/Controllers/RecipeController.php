<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RecipeController extends Controller
{
    /**
     * Display list of all recipes (timeline)
     */
    public function index(Request $request): View
    {
        $recipes = Recipe::approved()
            ->with(['user', 'kuliner'])
            ->latest()
            ->paginate(12);

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show form for creating a new recipe
     */
    public function create(): View
    {
        $kuliners = Kuliner::active()->orderBy('name')->get();
        return view('recipes.create', compact('kuliners'));
    }

    /**
     * Store a new recipe
     */
    public function store(Request $request): RedirectResponse
    {
        // Get image file reference
        $imageFile = $request->file('image');
        
        // Debug logging
        \Log::info('=== RECIPE STORE DEBUG ===');
        \Log::info('Has image file (hasFile): ' . ($request->hasFile('image') ? 'YES' : 'NO'));
        \Log::info('Image file object exists: ' . ($imageFile ? 'YES' : 'NO'));
        
        if ($imageFile) {
            \Log::info('Image details: ' . json_encode([
                'original_name' => $imageFile->getClientOriginalName(),
                'size' => $imageFile->getSize(),
                'mime' => $imageFile->getMimeType(),
                'valid' => $imageFile->isValid(),
                'error' => $imageFile->getError(),
                'error_message' => $imageFile->getErrorMessage(),
            ]));
        }

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'kuliner_id' => 'nullable|exists:kuliners,id',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'nullable|string|max:500',
            'steps' => 'required|array|min:1',
            'steps.*' => 'nullable|string|max:2000',
            'prep_time' => 'nullable|integer|min:0',
            'cooking_time' => 'nullable|integer|min:0',
            'servings' => 'nullable|integer|min:1|max:100',
            'difficulty' => 'nullable|in:mudah,sedang,sulit',
            'tips' => 'nullable|string|max:2000',
        ];

        // Only validate image if one was uploaded and is valid
        if ($imageFile && $imageFile->isValid()) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'; // 2MB max (PHP default)
        }

        $request->validate($rules);

        $imagePath = null;
        if ($imageFile && $imageFile->isValid()) {
            try {
                $imagePath = $imageFile->store('recipes', 'public');
                \Log::info('Image uploaded successfully: ' . $imagePath);
            } catch (\Exception $e) {
                \Log::error('Recipe image upload failed: ' . $e->getMessage());
            }
        } elseif ($imageFile) {
            \Log::warning('Image file exists but is invalid. Error code: ' . $imageFile->getError() . ' - ' . $imageFile->getErrorMessage());
        }

        // Filter out empty ingredients and steps
        $ingredients = array_filter($request->ingredients, fn($item) => !empty(trim($item)));
        $steps = array_filter($request->steps, fn($item) => !empty(trim($item)));

        $recipe = Recipe::create([
            'user_id' => auth()->id(),
            'kuliner_id' => $request->kuliner_id,
            'title' => $request->title,
            'description' => $request->description,
            'ingredients' => array_values($ingredients),
            'steps' => array_values($steps),
            'image' => $imagePath,
            'prep_time' => $request->prep_time ?: null,
            'cooking_time' => $request->cooking_time ?: null,
            'servings' => $request->servings ?: 4,
            'difficulty' => $request->difficulty ?: 'mudah',
            'tips' => $request->tips,
            'is_approved' => true, // Auto-approve new recipes
        ]);

        return redirect()
            ->route('recipes.show', $recipe->slug)
            ->with('success', 'Resep berhasil dibuat dan dipublikasikan!');
    }

    /**
     * Display a single recipe
     */
    public function show(string $slug): View
    {
        $recipe = Recipe::where('slug', $slug)
            ->approved()
            ->with(['user', 'kuliner'])
            ->firstOrFail();

        // Increment views
        $recipe->incrementViews();

        // Get related recipes
        $relatedRecipes = Recipe::approved()
            ->where('id', '!=', $recipe->id)
            ->when($recipe->kuliner_id, function ($query) use ($recipe) {
                $query->where('kuliner_id', $recipe->kuliner_id);
            })
            ->latest()
            ->take(4)
            ->get();

        $isBookmarked = auth()->check() 
            ? auth()->user()->bookmarks()->where('recipe_id', $recipe->id)->exists() 
            : false;
            
        $isLiked = $recipe->isLikedBy(auth()->user());

        return view('recipes.show', compact('recipe', 'relatedRecipes', 'isBookmarked', 'isLiked'));
    }

    /**
     * Show form for editing a recipe
     */
    public function edit(Recipe $recipe): View
    {
        // Check ownership
        if ($recipe->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit resep ini');
        }

        $kuliners = Kuliner::active()->orderBy('name')->get();
        return view('recipes.edit', compact('recipe', 'kuliners'));
    }

    /**
     * Update a recipe
     */
    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        // Check ownership
        if ($recipe->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit resep ini');
        }

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'kuliner_id' => 'nullable|exists:kuliners,id',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'nullable|string|max:500',
            'steps' => 'required|array|min:1',
            'steps.*' => 'nullable|string|max:2000',
            'prep_time' => 'nullable|integer|min:0',
            'cooking_time' => 'nullable|integer|min:0',
            'servings' => 'nullable|integer|min:1',
            'difficulty' => 'nullable|in:mudah,sedang,sulit',
            'tips' => 'nullable|string|max:2000',
        ];

        // Only validate image if one was uploaded
        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'; // 5MB max
        }

        $request->validate($rules);

        // Filter out empty ingredients and steps
        $ingredients = array_values(array_filter(
            $request->ingredients,
            fn($item) => !empty(trim($item))
        ));

        $steps = array_values(array_filter(
            $request->steps,
            fn($item) => !empty(trim($item))
        ));

        $data = [
            'kuliner_id' => $request->kuliner_id,
            'title' => $request->title,
            'description' => $request->description,
            'ingredients' => $ingredients,
            'steps' => $steps,
            'prep_time' => $request->prep_time,
            'cooking_time' => $request->cooking_time,
            'servings' => $request->servings,
            'difficulty' => $request->difficulty ?: 'mudah',
            'tips' => $request->tips,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            try {
                $data['image'] = $request->file('image')->store('recipes', 'public');
            } catch (\Exception $e) {
                \Log::error('Recipe image upload failed: ' . $e->getMessage());
            }
        }

        $recipe->update($data);

        return redirect()
            ->route('recipes.show', $recipe->slug)
            ->with('success', 'Resep berhasil diperbarui');
    }

    /**
     * Delete a recipe
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        // Check ownership
        if ($recipe->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus resep ini');
        }

        // Delete image if any
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()
            ->route('recipes.index')
            ->with('success', 'Resep berhasil dihapus');
    }

    /**
     * Display user's own recipes
     */
    public function myRecipes(): View
    {
        $recipes = Recipe::where('user_id', auth()->id())
            ->with('kuliner')
            ->latest()
            ->paginate(12);

        return view('recipes.my-recipes', compact('recipes'));
    }
}
