<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Kuliner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    /**
     * Get list of kuliners
     */
    public function index(Request $request): JsonResponse
    {
        $categoryId = $request->input('category');
        $search = $request->input('search');
        $sort = $request->input('sort', 'rating'); // rating, latest, name
        $perPage = $request->input('per_page', 15);

        $kuliners = Kuliner::active()
            ->with('category:id,name,slug')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
            ->when($sort === 'rating', function ($query) {
                $query->orderBy('average_rating', 'desc');
            })
            ->when($sort === 'latest', function ($query) {
                $query->latest();
            })
            ->when($sort === 'name', function ($query) {
                $query->orderBy('name');
            })
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $kuliners,
        ]);
    }

    /**
     * Get single kuliner detail
     */
    public function show(string $id): JsonResponse
    {
        $kuliner = Kuliner::with([
            'category:id,name,slug',
            'comments' => function ($query) {
                $query->approved()
                    ->with('user:id,name,avatar')
                    ->latest()
                    ->take(10);
            },
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $kuliner,
        ]);
    }

    /**
     * Get top rated kuliners
     */
    public function topRated(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);

        $kuliners = Kuliner::active()
            ->with('category:id,name,slug')
            ->topRated($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kuliners,
        ]);
    }

    /**
     * Get featured kuliners
     */
    public function featured(): JsonResponse
    {
        $kuliners = Kuliner::active()
            ->featured()
            ->with('category:id,name,slug')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kuliners,
        ]);
    }

    /**
     * Get all categories
     */
    public function categories(): JsonResponse
    {
        $categories = Category::withCount('kuliners')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get kuliners by category
     */
    public function byCategory(string $categoryId, Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $category = Category::findOrFail($categoryId);

        $kuliners = Kuliner::active()
            ->where('category_id', $categoryId)
            ->orderBy('average_rating', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'kuliners' => $kuliners,
            ],
        ]);
    }

    /**
     * Rate a kuliner
     */
    public function rate(Request $request, Kuliner $kuliner): JsonResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $kuliner->ratings()->updateOrCreate(
            ['user_id' => $request->user()->id],
            ['rating' => $request->rating]
        );

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil disimpan',
            'data' => [
                'average_rating' => $kuliner->fresh()->average_rating,
                'total_reviews' => $kuliner->total_reviews,
            ],
        ]);
    }

    /**
     * Add comment to a kuliner
     */
    public function comment(Request $request, Kuliner $kuliner): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|min:10|max:1000',
        ]);

        $comment = $kuliner->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);

        $comment->load('user:id,name,avatar');

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan',
            'data' => $comment,
        ], 201);
    }
}
