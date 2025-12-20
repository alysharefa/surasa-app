<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
       /**
     * Toggle like for a recipe
     */
    public function toggleRecipe(Recipe $recipe): RedirectResponse
    {
        $user = auth()->user();

        if ($recipe->isLikedBy($user)) {
            $recipe->likes()->where('user_id', $user->id)->delete();
            $message = 'Anda batal menyukai resep ini.';
        } else {
            $recipe->likes()->create(['user_id' => $user->id]);
            $message = 'Anda menyukai resep ini!';
        }

        return back()->with('success', $message);
    }

    /**
     * Toggle like for a kuliner
     */
    public function toggleKuliner(Kuliner $kuliner): RedirectResponse
    {
        $user = auth()->user();

        if ($kuliner->isLikedBy($user)) {
            $kuliner->likes()->where('user_id', $user->id)->delete();
            $message = 'Anda batal menyukai kuliner ini.';
        } else {
            $kuliner->likes()->create(['user_id' => $user->id]);
            $message = 'Anda menyukai kuliner ini!';
        }

        return back()->with('success', $message);
    }
    //
}
