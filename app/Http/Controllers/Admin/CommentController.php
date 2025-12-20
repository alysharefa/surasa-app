<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'all');

        $comments = Comment::with(['user', 'kuliner'])
            ->when($status === 'approved', function ($query) {
                $query->approved();
            })
            ->when($status === 'pending', function ($query) {
                $query->pending();
            })
            ->latest()
            ->paginate(15);

        return view('admin.comments.index', compact('comments', 'status'));
    }

    /**
     * Approve a comment
     */
    public function approve(Comment $comment): RedirectResponse
    {
        $comment->update(['is_approved' => true]);

        return back()->with('success', 'Komentar berhasil disetujui');
    }

    /**
     * Reject/disapprove a comment
     */
    public function reject(Comment $comment): RedirectResponse
    {
        $comment->update(['is_approved' => false]);

        return back()->with('success', 'Komentar berhasil ditolak');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment): RedirectResponse
    {
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
