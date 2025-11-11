<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return response()->json($ingredients);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'benefits' => 'required|string',
            'usage_instructions' => 'required|string',
            'type' => 'required|string'
        ]);

        $ingredient = Ingredient::create($request->all());

        return response()->json([
            'message' => 'Ingredient created successfully',
            'ingredient' => $ingredient
        ], 201);
    }
}