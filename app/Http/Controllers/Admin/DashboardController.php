<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Kuliner;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_kuliners' => Kuliner::count(),
            'total_categories' => Category::count(),
            'total_recipes' => Recipe::count(),
            'pending_comments' => Comment::pending()->count(),
            'pending_recipes' => Recipe::pending()->count(),
        ];

        $latestKuliners = Kuliner::with('category')
            ->latest()
            ->take(5)
            ->get();

        $latestComments = Comment::with(['user', 'kuliner'])
            ->latest()
            ->take(5)
            ->get();

        $topRatedKuliners = Kuliner::with('category')
            ->orderBy('average_rating', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestKuliners',
            'latestComments',
            'topRatedKuliners'
        ));
    }
    //
}
