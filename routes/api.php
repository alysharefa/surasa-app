<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KulinerController;
use App\Http\Controllers\Api\RecipeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Kuliners
Route::get('/kuliners', [KulinerController::class, 'index']);
Route::get('/kuliners/top-rated', [KulinerController::class, 'topRated']);
Route::get('/kuliners/featured', [KulinerController::class, 'featured']);
Route::get('/kuliners/{id}', [KulinerController::class, 'show']);

// Categories
Route::get('/categories', [KulinerController::class, 'categories']);
Route::get('/categories/{categoryId}/kuliners', [KulinerController::class, 'byCategory']);

// Recipes
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected API Routes (requires authentication)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    // User info & logout
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rating & Comments
    Route::post('/kuliners/{kuliner}/rate', [KulinerController::class, 'rate']);
    Route::post('/kuliners/{kuliner}/comment', [KulinerController::class, 'comment']);

    // Recipes
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes']);
    Route::post('/recipes', [RecipeController::class, 'store']);
});
