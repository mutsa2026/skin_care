<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\SkinType;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        // No middleware needed here - routes handle authentication
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_recipes' => Recipe::count(),
            'active_recipes' => Recipe::where('status', 'active')->count(),
            'pending_recipes' => Recipe::where('status', 'pending')->count(),
            'total_ingredients' => Ingredient::count(),
            'total_skin_types' => SkinType::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_recipes' => Recipe::with('skinType')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function dashboardApi()
    {
        $stats = [
            'total_users' => User::count(),
            'total_recipes' => Recipe::count(),
            'active_recipes' => Recipe::where('status', 'active')->count(),
            'pending_recipes' => Recipe::where('status', 'pending')->count(),
        ];

        $recentActivities = [
            'new_users' => User::latest()->take(5)->get(['id', 'name', 'created_at']),
            'recent_recipes' => Recipe::with('user:id,name')->latest()->take(5)->get(['id', 'title', 'user_id', 'created_at']),
            'recent_comments' => Comment::with(['user:id,name', 'recipe:id,title'])->latest()->take(5)->get(['id', 'user_id', 'recipe_id', 'content', 'created_at']),
        ];

        $weeklyUsers = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subWeeks(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $recipeCategories = Recipe::selectRaw('skin_types.name as category, COUNT(*) as count')
            ->join('skin_types', 'recipes.skin_type_id', '=', 'skin_types.id')
            ->groupBy('skin_types.name')
            ->get();

        $skinTypeStats = Recipe::selectRaw('skin_types.name, COUNT(*) as count')
            ->join('skin_types', 'recipes.skin_type_id', '=', 'skin_types.id')
            ->groupBy('skin_types.name')
            ->get();

        return response()->json([
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'weeklyUsers' => $weeklyUsers,
            'recipeCategories' => $recipeCategories,
            'skinTypeStats' => $skinTypeStats,
        ]);
    }

    public function analyticsApi()
    {
        $engagementStats = [
            'average_likes_per_recipe' => Recipe::withCount('likes')->get()->avg('likes_count') ?? 0,
            'average_comments_per_recipe' => Recipe::withCount('comments')->get()->avg('comments_count') ?? 0,
            'total_shares' => 0, // Placeholder for shares functionality
        ];

        return response()->json([
            'engagementStats' => $engagementStats,
        ]);
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function recipes()
    {
        $recipes = Recipe::with(['skinType', 'ingredients'])->paginate(20);
        return view('admin.recipes.index', compact('recipes'));
    }

    public function ingredients()
    {
        $ingredients = Ingredient::paginate(20);
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function skinTypes()
    {
        $skinTypes = SkinType::paginate(20);
        return view('admin.skin-types.index', compact('skinTypes'));
    }

    // CRUD operations for Users
    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    // CRUD operations for Recipes
    public function createRecipe()
    {
        $skinTypes = SkinType::all();
        $ingredients = Ingredient::all();
        return view('admin.recipes.create', compact('skinTypes', 'ingredients'));
    }

    public function storeRecipe(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'preparation_time' => 'required|integer|min:1',
            'skin_type_id' => 'required|exists:skin_types,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'servings' => 'required|integer|min:1',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
            'ingredients.*.measurement_unit' => 'required|string|max:50',
        ]);

        $recipe = Recipe::create($request->except('ingredients'));

        foreach ($request->ingredients as $ingredient) {
            $recipe->ingredients()->attach($ingredient['id'], [
                'quantity' => $ingredient['quantity'],
                'measurement_unit' => $ingredient['measurement_unit']
            ]);
        }

        return redirect()->route('admin.recipes')->with('success', 'Recipe created successfully.');
    }

    public function editRecipe(Recipe $recipe)
    {
        $skinTypes = SkinType::all();
        $ingredients = Ingredient::all();
        return view('admin.recipes.edit', compact('recipe', 'skinTypes', 'ingredients'));
    }

    public function updateRecipe(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'preparation_time' => 'required|integer|min:1',
            'skin_type_id' => 'required|exists:skin_types,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'servings' => 'required|integer|min:1',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
            'ingredients.*.measurement_unit' => 'required|string|max:50',
        ]);

        $recipe->update($request->except('ingredients'));

        $recipe->ingredients()->detach();
        foreach ($request->ingredients as $ingredient) {
            $recipe->ingredients()->attach($ingredient['id'], [
                'quantity' => $ingredient['quantity'],
                'measurement_unit' => $ingredient['measurement_unit']
            ]);
        }

        return redirect()->route('admin.recipes')->with('success', 'Recipe updated successfully.');
    }

    public function deleteRecipe(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('admin.recipes')->with('success', 'Recipe deleted successfully.');
    }

    // CRUD operations for Ingredients
    public function createIngredient()
    {
        return view('admin.ingredients.create');
    }

    public function storeIngredient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients',
            'description' => 'nullable|string',
        ]);

        Ingredient::create($request->all());
        return redirect()->route('admin.ingredients')->with('success', 'Ingredient created successfully.');
    }

    public function editIngredient(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    public function updateIngredient(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'description' => 'nullable|string',
        ]);

        $ingredient->update($request->all());
        return redirect()->route('admin.ingredients')->with('success', 'Ingredient updated successfully.');
    }

    public function deleteIngredient(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('admin.ingredients')->with('success', 'Ingredient deleted successfully.');
    }

    // CRUD operations for Skin Types
    public function createSkinType()
    {
        return view('admin.skin-types.create');
    }

    public function storeSkinType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skin_types',
            'description' => 'nullable|string',
        ]);

        SkinType::create($request->all());
        return redirect()->route('admin.skin-types')->with('success', 'Skin type created successfully.');
    }

    public function editSkinType(SkinType $skinType)
    {
        return view('admin.skin-types.edit', compact('skinType'));
    }

    public function updateSkinType(Request $request, SkinType $skinType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skin_types,name,' . $skinType->id,
            'description' => 'nullable|string',
        ]);

        $skinType->update($request->all());
        return redirect()->route('admin.skin-types')->with('success', 'Skin type updated successfully.');
    }

    public function deleteSkinType(SkinType $skinType)
    {
        $skinType->delete();
        return redirect()->route('admin.skin-types')->with('success', 'Skin type deleted successfully.');
    }
}
