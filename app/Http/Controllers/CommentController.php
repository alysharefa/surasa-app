<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Kuliner;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
        /**
     * Store a new comment
     */
    public function store(Request $request, Kuliner $kuliner): RedirectResponse
    {
        Log::info('Comment store attempt', ['user' => auth()->id(), 'kuliner' => $kuliner->id, 'data' => $request->all()]);

        $request->validate([
            'content' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 1. Save Rating
        $rating = Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'kuliner_id' => $kuliner->id],
            ['rating' => $request->rating]
        );
        Log::info('Rating saved', ['id' => $rating->id]);
        
        $kuliner->updateAverageRating();

        // 2. Save Comment
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('comments', 'public');
                $images[] = $path;
            }
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'kuliner_id' => $kuliner->id,
            'content' => $request->content,
            'images' => $images ?: null,
            'is_approved' => 1,
        ]);
        
        Log::info('Comment created', ['id' => $comment->id, 'is_approved' => $comment->is_approved]);

        return back()->with('success', 'Ulasan dan rating berhasil dikirim!');
    }

    /**
     * Update a comment
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        // Check ownership
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit komentar ini');
        }

        $request->validate([
            'content' => 'required|string|min:10|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil diperbarui');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // Check ownership or admin
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus komentar ini');
        }

        // Delete images if any
        if ($comment->images) {
            foreach ($comment->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus');
    }
    //
}
