<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KulinerController extends Controller
{
    /**
     * Display list of all kuliners
     */
    public function index(Request $request): View
    {
        $categoryId = $request->input('category');
        $sort = $request->input('sort', 'rating');
        $search = $request->input('search');

        $kuliners = Kuliner::active()
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
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
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('kuliners.index', compact('kuliners', 'categories', 'categoryId', 'sort', 'search'));
    }

    /**
     * Display single kuliner detail
     */
    public function show(string $slug): View
    {
        $kuliner = Kuliner::where('slug', $slug)
            ->with([
                'category',
                'comments' => function ($query) {
                    $query->with('user')->latest();
                },
                'recipes' => function ($query) {
                    $query->approved()->with('user')->latest()->take(3);
                }
            ])
            ->firstOrFail();

        // Get user's rating if logged in
        $userRating = null;
        if (Auth::check()) {
            $userRating = $kuliner->ratings()
                ->where('user_id', Auth::id())
                ->first();
        }

        // Get related kuliners from same category
        $relatedKuliners = Kuliner::active()
            ->where('category_id', $kuliner->category_id)
            ->where('id', '!=', $kuliner->id)
            ->topRated(4)
            ->get();

        // Calculate rating distribution
        $ratingCounts = $kuliner->ratings()
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();
            
        $ratingDistribution = [];
        $totalRatings = $kuliner->total_reviews > 0 ? $kuliner->total_reviews : 1; // Avoid division by zero
        
        for ($i = 5; $i >= 1; $i--) {
            $count = $ratingCounts[$i] ?? 0;
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => ($count / $totalRatings) * 100
            ];
        }
        
        $isLiked = $kuliner->isLikedBy(Auth::user());

        return view('kuliners.show', compact('kuliner', 'userRating', 'relatedKuliners', 'ratingDistribution', 'isLiked'));
    }

    /**
     * Display kuliners by category
     */
    public function byCategory(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $kuliners = Kuliner::active()
            ->where('category_id', $category->id)
            ->orderBy('average_rating', 'desc')
            ->paginate(12);

        return view('kuliners.category', compact('category', 'kuliners'));
    }
}
