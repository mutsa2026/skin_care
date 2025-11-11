@extends('admin.layout')

@section('title', 'Admin Dashboard - Skincare Recipes')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-tachometer-alt text-primary me-2"></i>Admin Dashboard
                </h1>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-1"></i>Back to Site
                </a>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold text-primary">{{ $stats['total_users'] }}</h3>
                    <p class="text-muted mb-0">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-book-open fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold text-success">{{ $stats['total_recipes'] }}</h3>
                    <p class="text-muted mb-0">Total Recipes</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-leaf fa-3x text-info mb-3"></i>
                    <h3 class="fw-bold text-info">{{ $stats['total_ingredients'] }}</h3>
                    <p class="text-muted mb-0">Total Ingredients</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-tags fa-3x text-warning mb-3"></i>
                    <h3 class="fw-bold text-warning">{{ $stats['total_skin_types'] }}</h3>
                    <p class="text-muted mb-0">Skin Types</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Management Sections --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs text-primary me-2"></i>Management Tools
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary w-100 p-3 h-100 d-flex flex-column align-items-center">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span>Manage Users</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.recipes') }}" class="btn btn-outline-success w-100 p-3 h-100 d-flex flex-column align-items-center">
                                <i class="fas fa-book-open fa-2x mb-2"></i>
                                <span>Manage Recipes</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.ingredients') }}" class="btn btn-outline-info w-100 p-3 h-100 d-flex flex-column align-items-center">
                                <i class="fas fa-leaf fa-2x mb-2"></i>
                                <span>Manage Ingredients</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.skin-types') }}" class="btn btn-outline-warning w-100 p-3 h-100 d-flex flex-column align-items-center">
                                <i class="fas fa-tags fa-2x mb-2"></i>
                                <span>Manage Skin Types</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-success me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Recent Users --}}
                    @if($stats['recent_users']->count() > 0)
                        <h6 class="text-muted mb-3">Recent Users</h6>
                        <div class="list-group list-group-flush">
                            @foreach($stats['recent_users'] as $user)
                                <div class="list-group-item px-0 py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No recent users</p>
                    @endif

                    <hr>

                    {{-- Recent Recipes --}}
                    @if($stats['recent_recipes']->count() > 0)
                        <h6 class="text-muted mb-3">Recent Recipes</h6>
                        <div class="list-group list-group-flush">
                            @foreach($stats['recent_recipes'] as $recipe)
                                <div class="list-group-item px-0 py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ Str::limit($recipe->title, 30) }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $recipe->skinType->name ?? 'Unknown' }} Skin</small>
                                        </div>
                                        <small class="text-muted">{{ $recipe->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No recent recipes</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-1"></i>Add User
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.recipes.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus me-1"></i>Add Recipe
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.ingredients.create') }}" class="btn btn-info w-100">
                                <i class="fas fa-leaf me-1"></i>Add Ingredient
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.skin-types.create') }}" class="btn btn-warning w-100">
                                <i class="fas fa-tag me-1"></i>Add Skin Type
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Admin Dashboard Styles */
.card {
    border-radius: 10px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.list-group-item {
    border: none;
    border-bottom: 1px solid #f8f9fa;
}

.list-group-item:last-child {
    border-bottom: none;
}
</style>
@endsection
