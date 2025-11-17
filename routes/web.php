<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home/Dashboard Route
Route::get('/', function () {
    return view('Dashboard');
})->name('home');

// Skin Faves Routes (formerly Browse Recipes)
Route::get('/skin-faves', [RecipeController::class, 'browse'])->name('recipes.browse');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes/{id}/preview', [RecipeController::class, 'preview'])->name('recipes.preview');

// Before & After Gallery Routes
Route::get('/before-after-gallery', [GalleryController::class, 'index'])->name('gallery.before-after');
Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery.index');
Route::post('/gallery/upload', [GalleryController::class, 'upload'])->name('gallery.upload');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');

// Contact Route
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Community Engagement Routes
Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::post('/recipes/{id}/like', [CommunityController::class, 'like'])->name('recipes.like');
Route::post('/recipes/{id}/comment', [CommunityController::class, 'comment'])->name('recipes.comment');
Route::post('/comments/{id}/reply', [CommunityController::class, 'reply'])->name('comments.reply');

// API Routes for AJAX
Route::prefix('api')->group(function () {
    Route::post('/recipes/{id}/favorite', [RecipeController::class, 'toggleFavorite']);
    Route::get('/recipes/{id}/preview', [RecipeController::class, 'getPreview']);
    Route::post('/gallery/{id}/like', [GalleryController::class, 'like']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');

        // Recipe Management
        Route::get('/recipes', [AdminController::class, 'recipes'])->name('recipes');
        Route::get('/recipes/create', [AdminController::class, 'createRecipe'])->name('recipes.create');
        Route::post('/recipes', [AdminController::class, 'storeRecipe'])->name('recipes.store');
        Route::get('/recipes/{recipe}/edit', [AdminController::class, 'editRecipe'])->name('recipes.edit');
        Route::put('/recipes/{recipe}', [AdminController::class, 'updateRecipe'])->name('recipes.update');
        Route::delete('/recipes/{recipe}', [AdminController::class, 'deleteRecipe'])->name('recipes.destroy');

        // Gallery Management
        Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
        Route::get('/gallery/create', [AdminController::class, 'createGallery'])->name('gallery.create');
        Route::post('/gallery', [AdminController::class, 'storeGallery'])->name('gallery.store');
        Route::get('/gallery/{galleryItem}/edit', [AdminController::class, 'editGallery'])->name('gallery.edit');
        Route::put('/gallery/{galleryItem}', [AdminController::class, 'updateGallery'])->name('gallery.update');
        Route::delete('/gallery/{galleryItem}', [AdminController::class, 'deleteGallery'])->name('gallery.destroy');

        // Contact Management
        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts');
        Route::get('/contacts/{contact}', [AdminController::class, 'showContact'])->name('contacts.show');
        Route::delete('/contacts/{contact}', [AdminController::class, 'deleteContact'])->name('contacts.destroy');

        // Ingredient Management
        Route::get('/ingredients', [AdminController::class, 'ingredients'])->name('ingredients');
        Route::get('/ingredients/create', [AdminController::class, 'createIngredient'])->name('ingredients.create');
        Route::post('/ingredients', [AdminController::class, 'storeIngredient'])->name('ingredients.store');
        Route::get('/ingredients/{ingredient}/edit', [AdminController::class, 'editIngredient'])->name('ingredients.edit');
        Route::put('/ingredients/{ingredient}', [AdminController::class, 'updateIngredient'])->name('ingredients.update');
        Route::delete('/ingredients/{ingredient}', [AdminController::class, 'deleteIngredient'])->name('ingredients.destroy');

        // Skin Type Management
        Route::get('/skin-types', [AdminController::class, 'skinTypes'])->name('skin-types');
        Route::get('/skin-types/create', [AdminController::class, 'createSkinType'])->name('skin-types.create');
        Route::post('/skin-types', [AdminController::class, 'storeSkinType'])->name('skin-types.store');
        Route::get('/skin-types/{skinType}/edit', [AdminController::class, 'editSkinType'])->name('skin-types.edit');
        Route::put('/skin-types/{skinType}', [AdminController::class, 'updateSkinType'])->name('skin-types.update');
        Route::delete('/skin-types/{skinType}', [AdminController::class, 'deleteSkinType'])->name('skin-types.destroy');
    });
});