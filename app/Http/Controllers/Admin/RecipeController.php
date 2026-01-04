<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'all');

        $recipes = Recipe::with(['user', 'kuliner'])
            ->when($status === 'approved', function ($query) {
                $query->approved();
            })
            ->when($status === 'pending', function ($query) {
                $query->pending();
            })
            ->latest()
            ->paginate(15);

        return view('admin.recipes.index', compact('recipes', 'status'));
    }

    /**
     * Show recipe details
     */
    public function show(Recipe $recipe): View
    {
        $recipe->load(['user', 'kuliner']);

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $isBookmarked = $user ? $user->bookmarks()->where('recipe_id', $recipe->id)->exists() : false;
        $isLiked = $recipe->isLikedBy($user);

        return view('admin.recipes.show', compact('recipe', 'isBookmarked', 'isLiked'));
    }

    /**
     * Approve a recipe
     */
    public function approve(Recipe $recipe): RedirectResponse
    {
        $recipe->update(['is_approved' => true]);

        return back()->with('success', 'Resep berhasil disetujui');
    }

    /**
     * Reject a recipe
     */
    public function reject(Recipe $recipe): RedirectResponse
    {
        $recipe->update(['is_approved' => false]);

        return back()->with('success', 'Resep berhasil ditolak');
    }

    /**
     * Delete a recipe
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        // Delete image if any
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return back()->with('success', 'Resep berhasil dihapus');
    }
    //
}
