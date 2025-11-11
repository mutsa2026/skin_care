<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\SkinTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('recipes', RecipeController::class)->names([
    'index' => 'api.recipes.index',
    'store' => 'api.recipes.store',
    'show' => 'api.recipes.show',
    'update' => 'api.recipes.update',
    'destroy' => 'api.recipes.destroy',
]);
Route::apiResource('ingredients', IngredientController::class);
Route::get('skin-types', [SkinTypeController::class, 'index']);

// Admin API routes
Route::prefix('admin')->name('admin.api.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\AdminController::class, 'dashboardApi'])->name('dashboard');
    Route::get('analytics', [App\Http\Controllers\AdminController::class, 'analyticsApi'])->name('analytics');
});
