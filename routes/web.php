<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KulinerController as AdminKulinerController;
use App\Http\Controllers\Admin\RecipeController as AdminRecipeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Kuliners
Route::get('/kuliners', [KulinerController::class, 'index'])->name('kuliners.index');
Route::get('/kuliners/{slug}', [KulinerController::class, 'show'])->name('kuliners.show');
Route::get('/kategori/{slug}', [KulinerController::class, 'byCategory'])->name('kuliners.category');

// Recipes (public view)
Route::get('/resep', [RecipeController::class, 'index'])->name('recipes.index');

// Recipe create route MUST be before {slug} route to avoid conflict
Route::middleware(['auth'])->group(function () {
    Route::get('/resep/buat', [RecipeController::class, 'create'])->name('recipes.create');
});

Route::get('/resep/{slug}', [RecipeController::class, 'show'])->name('recipes.show');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Redirect dashboard to home (for backward compatibility)
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ratings
    Route::post('/kuliners/{kuliner}/rating', [RatingController::class, 'store'])->name('ratings.store');
    Route::delete('/kuliners/{kuliner}/rating', [RatingController::class, 'destroy'])->name('ratings.destroy');

    // Comments
    Route::post('/kuliners/{kuliner}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Recipes (user management)
    Route::get('/resep-saya', [RecipeController::class, 'myRecipes'])->name('recipes.my');
    Route::get('/resep-tersimpan', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/resep/{recipe}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::post('/resep/{recipe}/like', [LikeController::class, 'toggleRecipe'])->name('recipes.like');
    Route::post('/kuliners/{kuliner}/like', [LikeController::class, 'toggleKuliner'])->name('kuliners.like');
    Route::post('/resep', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/resep/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/resep/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/resep/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Kuliners
        Route::resource('kuliners', AdminKulinerController::class);
        Route::patch('kuliners/{kuliner}/toggle-featured', [AdminKulinerController::class, 'toggleFeatured'])->name('kuliners.toggle-featured');
        Route::patch('kuliners/{kuliner}/toggle-active', [AdminKulinerController::class, 'toggleActive'])->name('kuliners.toggle-active');

        // Comments
        Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
        Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
        Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

        // Recipes
        Route::get('recipes', [AdminRecipeController::class, 'index'])->name('recipes.index');
        Route::get('recipes/{recipe}', [AdminRecipeController::class, 'show'])->name('recipes.show');
        Route::patch('recipes/{recipe}/approve', [AdminRecipeController::class, 'approve'])->name('recipes.approve');
        Route::patch('recipes/{recipe}/reject', [AdminRecipeController::class, 'reject'])->name('recipes.reject');
        Route::delete('recipes/{recipe}', [AdminRecipeController::class, 'destroy'])->name('recipes.destroy');

        // Users
        Route::resource('users', AdminUserController::class);
        Route::patch('users/{user}/change-role', [AdminUserController::class, 'changeRole'])->name('users.change-role');
    });

// Include Laravel Breeze auth routes
require __DIR__.'/auth.php';
