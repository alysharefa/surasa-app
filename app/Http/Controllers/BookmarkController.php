<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
        /**
     * Display a listing of the bookmarked recipes.
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $recipes = $user->bookmarks()
            ->with(['user', 'kuliner']) // Eager load user (author) and kuliner
            ->latest('bookmarks.created_at') // Sort by when it was bookmarked
            ->paginate(12);

        return view('recipes.bookmarks', compact('recipes'));
    }

    /**
     * Toggle bookmark for a recipe.
     */
    public function toggle(Recipe $recipe)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $user->bookmarks()->toggle($recipe->id);
        
        // Return back implies this is a form submission redirect
        // Ideally this should be an AJAX call, but for MVP reload is fine.
        // We check if it was attached or detached to give proper message.
        $isBookmarked = $user->bookmarks()->where('recipe_id', $recipe->id)->exists();
        $message = $isBookmarked ? 'Resep disimpan ke koleksi Anda.' : 'Resep dihapus dari koleksi.';

        return back()->with('success', $message);
    }
    //
}
