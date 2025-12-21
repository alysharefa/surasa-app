<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store or update a rating
     */
    public function store(Request $request, Kuliner $kuliner): RedirectResponse|JsonResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'kuliner_id' => $kuliner->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rating berhasil disimpan',
                'rating' => $rating,
                'average_rating' => $kuliner->fresh()->average_rating,
            ]);
        }

        return back()->with('success', 'Rating berhasil disimpan');
    }

    /**
     * Remove a rating
     */
    public function destroy(Kuliner $kuliner): RedirectResponse|JsonResponse
    {
        $rating = Rating::where('user_id', Auth::id())
            ->where('kuliner_id', $kuliner->id)
            ->first();

        if ($rating) {
            $rating->delete();
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rating berhasil dihapus',
                'average_rating' => $kuliner->fresh()->average_rating,
            ]);
        }

        return back()->with('success', 'Rating berhasil dihapus');
    }
}
