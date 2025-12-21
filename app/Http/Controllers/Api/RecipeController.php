<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Get list of recipes
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $recipes = Recipe::approved()
            ->with(['user:id,name,avatar', 'kuliner:id,name,slug'])
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }

    /**
     * Get single recipe detail
     */
    public function show(string $id): JsonResponse
    {
        $recipe = Recipe::approved()
            ->with(['user:id,name,avatar', 'kuliner:id,name,slug,image'])
            ->findOrFail($id);

        $recipe->incrementViews();

        return response()->json([
            'success' => true,
            'data' => $recipe,
        ]);
    }

    /**
     * Store a new recipe
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'kuliner_id' => 'nullable|exists:kuliners,id',
            'ingredients' => 'required|array|min:1',
            'steps' => 'required|array|min:1',
            'cooking_time' => 'nullable|integer|min:1',
            'servings' => 'nullable|integer|min:1',
            'difficulty' => 'required|in:mudah,sedang,sulit',
        ]);

        $recipe = Recipe::create([
            'user_id' => $request->user()->id,
            'kuliner_id' => $request->kuliner_id,
            'title' => $request->title,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'steps' => $request->steps,
            'cooking_time' => $request->cooking_time,
            'servings' => $request->servings,
            'difficulty' => $request->difficulty,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil dibuat',
            'data' => $recipe,
        ], 201);
    }

    /**
     * Get user's recipes
     */
    public function myRecipes(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $recipes = Recipe::where('user_id', $request->user()->id)
            ->with('kuliner:id,name,slug')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }
}
