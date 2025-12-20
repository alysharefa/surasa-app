<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Category;
use App\Models\Kuliner;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
        /**
     * Display the homepage with recommendations
     */
    public function index(): View
    {
        // Get top rated kuliners for recommendations
        $topRated = Kuliner::active()
            ->with('category')
            ->topRated(8)
            ->get();

        // Get featured kuliners
        $featured = Kuliner::active()
            ->featured()
            ->with('category')
            ->take(4)
            ->get();

        // Get latest kuliners
        $latest = Kuliner::active()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        // Get categories
        $categories = Category::withCount('kuliners')
            ->orderBy('name')
            ->get();

        // Get latest recipes
        $latestRecipes = Recipe::approved()
            ->with(['user', 'kuliner'])
            ->latest()
            ->take(4)
            ->get();

        // Get total counts for statistics
        $totalCategories = Category::count();
        $totalKuliners = Kuliner::active()->count();
        $totalRecipes = Recipe::approved()->count();

        return view('home', compact(
            'topRated',
            'featured',
            'latest',
            'categories',
            'latestRecipes',
            'totalCategories',
            'totalKuliners',
            'totalRecipes'
        ));
    }

    /**
     * Search kuliners
     */
    public function search(Request $request): View
    {
        $query = $request->input('q');
        $categoryId = $request->input('category');
        $sort = $request->input('sort');

        $kuliners = Kuliner::active()
            ->with('category')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%");
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($sort === 'latest', function ($q) {
                $q->latest();
            })
            ->when($sort === 'price_asc', function ($q) {
                $q->orderBy('price_min', 'asc');
            })
            ->when($sort === 'price_desc', function ($q) {
                $q->orderBy('price_max', 'desc');
            })
            ->when(!$sort || $sort === 'rating', function ($q) {
                $q->orderBy('average_rating', 'desc');
            })
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('search', compact('kuliners', 'categories', 'query', 'categoryId', 'sort'));
    }
=======
use Illuminate\Http\Request;

class HomeController extends Controller
{
>>>>>>> 3d0d46a16636d146929ae16ec46d24ba4c830240
    //
}
