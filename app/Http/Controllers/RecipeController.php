<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SkinType;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipeRequest;

class RecipeController extends Controller
{
    public function browse(Request $request)
    {
        $query = Recipe::with(['skinType', 'ingredients']);

        // Apply filters
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('skinType') && !empty($request->skinType)) {
            $skinType = SkinType::where('name', $request->skinType)->first();
            if ($skinType) {
                $query->where('skin_type_id', $skinType->id);
            }
        }

        if ($request->has('difficulty') && !empty($request->difficulty)) {
            $query->whereIn('difficulty_level', $request->difficulty);
        }

        if ($request->has('maxPrepTime') && $request->maxPrepTime > 0) {
            $query->where('preparation_time', '<=', $request->maxPrepTime);
        }

        if ($request->has('vegan') && $request->vegan) {
            $query->where('vegan', true);
        }

        if ($request->has('organic') && $request->organic) {
            $query->where('organic', true);
        }

        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        // Sorting
        $sortBy = $request->get('sortBy', 'newest');
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'preparation_time':
                $query->orderBy('preparation_time', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $recipes = $query->paginate(12);
        $skinTypes = SkinType::all();

        // Get category counts
        $categoryCounts = [
            'face_mask' => Recipe::where('category', 'face_mask')->count(),
            'serum' => Recipe::where('category', 'serum')->count(),
            'moisturizer' => Recipe::where('category', 'moisturizer')->count(),
            'cleanser' => Recipe::where('category', 'cleanser')->count(),
            'toner' => Recipe::where('category', 'toner')->count(),
            'exfoliant' => Recipe::where('category', 'exfoliant')->count(),
            'scrub' => Recipe::where('category', 'scrub')->count(),
            'lip_care' => Recipe::where('category', 'lip_care')->count(),
        ];

        $totalRecipes = Recipe::count();

        return view('browse-recipes', compact('recipes', 'skinTypes', 'categoryCounts', 'totalRecipes'));
    }

    public function index(Request $request)
    {
        $query = Recipe::with(['skinType', 'ingredients']);

        if ($request->has('skin_type')) {
            $query->where('skin_type_id', $request->skin_type);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $recipes = $query->paginate(10);
        $skinTypes = SkinType::all();

        // Check if request expects JSON (API call) or HTML (web view)
        if ($request->expectsJson()) {
            return response()->json([
                'recipes' => $recipes,
                'skin_types' => $skinTypes
            ]);
        }

        // Return view for web browsing
        return view('browse-recipes', compact('recipes', 'skinTypes'));
    }

    public function store(StoreRecipeRequest $request)
    {
        $recipe = Recipe::create($request->validated());

        // Attach ingredients
        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredient) {
                $recipe->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantity'],
                    'measurement_unit' => $ingredient['measurement_unit']
                ]);
            }
        }

        return response()->json([
            'message' => 'Recipe created successfully',
            'recipe' => $recipe->load(['skinType', 'ingredients'])
        ], 201);
    }

    public function show($id)
    {
        $recipe = Recipe::with(['skinType', 'ingredients'])->findOrFail($id);

        // Check if request expects JSON (API call) or HTML (web view)
        if (request()->expectsJson()) {
            return response()->json($recipe);
        }

        // Return view for individual recipe page
        return view('recipes', compact('recipe'));
    }

    public function update(StoreRecipeRequest $request, $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update($request->validated());

        // Sync ingredients
        if ($request->has('ingredients')) {
            $recipe->ingredients()->detach();
            foreach ($request->ingredients as $ingredient) {
                $recipe->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantity'],
                    'measurement_unit' => $ingredient['measurement_unit']
                ]);
            }
        }

        return response()->json([
            'message' => 'Recipe updated successfully',
            'recipe' => $recipe->load(['skinType', 'ingredients'])
        ]);
    }

    public function create()
    {
        $skinTypes = SkinType::all();
        $ingredients = Ingredient::all();

        return view('create-recipe', compact('skinTypes', 'ingredients'));
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted successfully']);
    }
}