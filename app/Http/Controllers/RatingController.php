<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Kuliner;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
=======
>>>>>>> 3d0d46a16636d146929ae16ec46d24ba4c830240
use Illuminate\Http\Request;

class RatingController extends Controller
{
<<<<<<< HEAD
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
                'user_id' => auth()->id(),
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
        $rating = Rating::where('user_id', auth()->id())
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
=======
>>>>>>> 3d0d46a16636d146929ae16ec46d24ba4c830240
    //
}
