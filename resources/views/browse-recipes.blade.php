@extends('layout')

@section('title', 'Browse Recipes | Natural Skincare Community')

@section('content')
<div class="container-fluid py-4">
  {{-- HERO SECTION FOR BROWSE PAGE --}}
  <section class="browse-hero bg-gradient-primary text-white rounded-4 p-5 mb-5">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-3">
          <i class="fas fa-search me-3"></i>Browse All Recipes
        </h1>
        <p class="lead mb-4 opacity-90">
          Discover {{ $totalRecipes ?? '300+' }} natural skincare recipes crafted by our community.
          From face masks to serums, find the perfect treatment for your skin type.
        </p>
        <div class="d-flex gap-3 flex-wrap">
          <button class="btn btn-light btn-lg px-4" onclick="document.getElementById('searchInput').focus()">
            <i class="fas fa-search me-2"></i>Start Exploring
          </button>
          <button class="btn btn-outline-light btn-lg px-4" data-bs-toggle="modal" data-bs-target="#advancedFiltersModal">
            <i class="fas fa-filter me-2"></i>Advanced Filters
          </button>
        </div>
      </div>
      <div class="col-lg-4 text-center">
        <div class="hero-illustration">
          <i class="fas fa-spa fa-6x opacity-20"></i>
        </div>
      </div>
    </div>
  </section>


  {{-- SKIN TYPES SECTION --}}
  <section class="skin-types-section mb-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold text-primary mb-3">
          <i class="fas fa-user-friends me-2"></i>Find Recipes by Skin Type
        </h2>
        <p class="text-muted">Select your skin type to see personalized recipe recommendations</p>
      </div>

      <div class="row g-4 justify-content-center">
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="skin-type-card card border-0 shadow-sm text-center p-4 h-100" onclick="filterBySkinType('Dry')">
            <div class="card-body">
              <i class="fas fa-user fa-3x text-primary mb-3"></i>
              <h5 class="card-title fw-bold mb-2">Dry Skin</h5>
              <p class="card-text text-muted small">Hydrating and nourishing recipes</p>
              <div class="mt-3">
                <span class="badge bg-primary">{{ \App\Models\Recipe::whereHas('skinType', function($q) { $q->where('name', 'Dry'); })->count() }} recipes</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="skin-type-card card border-0 shadow-sm text-center p-4 h-100" onclick="filterBySkinType('Oily')">
            <div class="card-body">
              <i class="fas fa-user fa-3x text-info mb-3"></i>
              <h5 class="card-title fw-bold mb-2">Oily Skin</h5>
              <p class="card-text text-muted small">Balancing and mattifying recipes</p>
              <div class="mt-3">
                <span class="badge bg-info">{{ \App\Models\Recipe::whereHas('skinType', function($q) { $q->where('name', 'Oily'); })->count() }} recipes</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="skin-type-card card border-0 shadow-sm text-center p-4 h-100" onclick="filterBySkinType('Combination')">
            <div class="card-body">
              <i class="fas fa-user fa-3x text-success mb-3"></i>
              <h5 class="card-title fw-bold mb-2">Combination</h5>
              <p class="card-text text-muted small">Mixed skin type recipes</p>
              <div class="mt-3">
                <span class="badge bg-success">{{ \App\Models\Recipe::whereHas('skinType', function($q) { $q->where('name', 'Combination'); })->count() }} recipes</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="skin-type-card card border-0 shadow-sm text-center p-4 h-100" onclick="filterBySkinType('Sensitive')">
            <div class="card-body">
              <i class="fas fa-user fa-3x text-warning mb-3"></i>
              <h5 class="card-title fw-bold mb-2">Sensitive</h5>
              <p class="card-text text-muted small">Gentle and soothing recipes</p>
              <div class="mt-3">
                <span class="badge bg-warning">{{ \App\Models\Recipe::whereHas('skinType', function($q) { $q->where('name', 'Sensitive'); })->count() }} recipes</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="skin-type-card card border-0 shadow-sm text-center p-4 h-100" onclick="filterBySkinType('Normal')">
            <div class="card-body">
              <i class="fas fa-user fa-3x text-secondary mb-3"></i>
              <h5 class="card-title fw-bold mb-2">Normal</h5>
              <p class="card-text text-muted small">General maintenance recipes</p>
              <div class="mt-3">
                <span class="badge bg-secondary">{{ \App\Models\Recipe::whereHas('skinType', function($q) { $q->where('name', 'Normal'); })->count() }} recipes</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
          <div class="skin-type-card card border-0 shadow-sm text-center p-4 h-100" onclick="filterBySkinType('Acne-Prone')">
            <div class="card-body">
              <i class="fas fa-user fa-3x text-danger mb-3"></i>
              <h5 class="card-title fw-bold mb-2">Acne-Prone</h5>
              <p class="card-text text-muted small">Clearing and healing recipes</p>
              <div class="mt-3">
                <span class="badge bg-danger">{{ \App\Models\Recipe::whereHas('skinType', function($q) { $q->where('name', 'Acne-Prone'); })->count() }} recipes</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- QUICK SEARCH BAR --}}
  <div class="search-bar mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <form method="GET" action="{{ route('recipes.index') }}" class="row g-3 align-items-end">
          <div class="col-md-8">
            <label for="searchInput" class="form-label fw-bold">
              <i class="fas fa-search me-2 text-primary"></i>Search Recipes
            </label>
            <input type="text" class="form-control form-control-lg" id="searchInput"
                   name="search" placeholder="Recipe name, ingredient, or keyword..."
                   value="{{ request('search') }}">
          </div>
          <div class="col-md-2">
            <label class="form-label fw-bold">
              <i class="fas fa-clock me-2 text-primary"></i>Max Time
            </label>
            <select name="maxPrepTime" class="form-select form-select-lg">
              <option value="">Any Time</option>
              <option value="15" {{ request('maxPrepTime') == '15' ? 'selected' : '' }}>15 min</option>
              <option value="30" {{ request('maxPrepTime') == '30' ? 'selected' : '' }}>30 min</option>
              <option value="60" {{ request('maxPrepTime') == '60' ? 'selected' : '' }}>1 hour</option>
              <option value="120" {{ request('maxPrepTime') == '120' ? 'selected' : '' }}>2+ hours</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-lg w-100">
              <i class="fas fa-search me-2"></i>Search
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- STATS CARDS --}}
  <div class="stats-section mb-5">
    <div class="row g-4">
      <div class="col-xl-3 col-lg-6">
        <div class="stat-card card h-100 border-0 shadow-sm text-center">
          <div class="card-body p-4">
            <div class="stat-icon mb-3">
              <i class="fas fa-seedling fa-3x text-success"></i>
            </div>
            <h3 class="fw-bold text-success mb-2">{{ \App\Models\Recipe::count() }}</h3>
            <p class="text-muted mb-0">Total Recipes</p>
            <div class="progress mt-3" style="height: 4px;">
              <div class="progress-bar bg-success" style="width: 100%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="stat-card card h-100 border-0 shadow-sm text-center">
          <div class="card-body p-4">
            <div class="stat-icon mb-3">
              <i class="fas fa-clock fa-3x text-info"></i>
            </div>
            <h3 class="fw-bold text-info mb-2">{{ \App\Models\Recipe::where('preparation_time', '<=', 15)->count() }}</h3>
            <p class="text-muted mb-0">Under 15 mins</p>
            <div class="progress mt-3" style="height: 4px;">
              <div class="progress-bar bg-info" style="width: {{ \App\Models\Recipe::count() > 0 ? round((\App\Models\Recipe::where('preparation_time', '<=', 15)->count() / \App\Models\Recipe::count()) * 100) : 0 }}%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="stat-card card h-100 border-0 shadow-sm text-center">
          <div class="card-body p-4">
            <div class="stat-icon mb-3">
              <i class="fas fa-leaf fa-3x text-success"></i>
            </div>
            <h3 class="fw-bold text-success mb-2">{{ \App\Models\Recipe::where('vegan', true)->count() }}</h3>
            <p class="text-muted mb-0">Vegan Recipes</p>
            <div class="progress mt-3" style="height: 4px;">
              <div class="progress-bar bg-success" style="width: {{ \App\Models\Recipe::count() > 0 ? round((\App\Models\Recipe::where('vegan', true)->count() / \App\Models\Recipe::count()) * 100) : 0 }}%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="stat-card card h-100 border-0 shadow-sm text-center">
          <div class="card-body p-4">
            <div class="stat-icon mb-3">
              <i class="fas fa-star fa-3x text-warning"></i>
            </div>
            <h3 class="fw-bold text-warning mb-2">{{ \App\Models\Recipe::where('is_featured', true)->count() }}</h3>
            <p class="text-muted mb-0">Featured</p>
            <div class="progress mt-3" style="height: 4px;">
              <div class="progress-bar bg-warning" style="width: {{ \App\Models\Recipe::count() > 0 ? round((\App\Models\Recipe::where('is_featured', true)->count() / \App\Models\Recipe::count()) * 100) : 0 }}%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- MAIN CONTENT WITH SIDEBAR LAYOUT --}}
  <div class="row">
    {{-- SIDEBAR WITH FILTERS --}}
    <aside class="col-lg-3 mb-4">
      <div class="sticky-top" style="top: 20px;">
        {{-- Mobile Filter Toggle --}}
        <div class="d-lg-none mb-3">
          <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar">
            <i class="fas fa-filter me-2"></i> Show Filters
          </button>
        </div>

        {{-- Filter Sidebar --}}
        <div class="collapse d-lg-block" id="filterSidebar">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
              <h5 class="mb-0 d-flex justify-content-between align-items-center">
                <span><i class="fas fa-sliders-h text-primary me-2"></i> Filters</span>
                <a href="{{ route('recipes.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
              </h5>
            </div>

            <div class="card-body">
              <form method="GET" action="{{ route('recipes.index') }}" id="filterForm">
                {{-- Search --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Search Recipes</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Recipe name, ingredient..."
                           value="{{ request('search') }}">
                  </div>
                </div>

                {{-- Category --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Category</label>
                  <div class="nav flex-column">
                    @foreach($categories ?? [
                      'face_mask' => 'Face Masks',
                      'serum' => 'Serums',
                      'moisturizer' => 'Moisturizers',
                      'cleanser' => 'Cleansers',
                      'toner' => 'Toners',
                      'exfoliant' => 'Exfoliants',
                      'scrub' => 'Scrubs',
                      'lip_care' => 'Lip Care'
                    ] as $key => $category)
                      <a href="{{ request()->fullUrlWithQuery(['category' => $key]) }}"
                         class="nav-link px-0 py-2 d-flex justify-content-between {{ request('category') == $key ? 'text-primary fw-bold' : 'text-muted' }}">
                        <span>{{ $category }}</span>
                        <span class="badge bg-light text-dark">{{ $categoryCounts[$key] ?? rand(5,50) }}</span>
                      </a>
                    @endforeach
                  </div>
                </div>

                {{-- Skin Type --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Skin Type</label>
                  <div class="row g-2">
                    @foreach($skinTypes ?? ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal', 'Acne-Prone'] as $type)
                      <div class="col-6">
                        <input type="radio" class="btn-check" name="skinType" id="skinType{{ $type }}"
                               value="{{ $type }}" {{ request('skinType') == $type ? 'checked' : '' }} autocomplete="off">
                        <label class="btn btn-outline-primary w-100 text-start" for="skinType{{ $type }}">
                          <i class="fas fa-user me-2"></i> {{ $type }}
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>

                {{-- Difficulty --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Difficulty Level</label>
                  <div class="d-flex flex-wrap gap-2">
                    @foreach($difficultyLevels ?? ['easy', 'medium', 'hard'] as $level)
                      <input type="checkbox" class="btn-check" name="difficulty[]" id="difficulty{{ ucfirst($level) }}"
                             value="{{ $level }}" {{ in_array($level, request('difficulty', [])) ? 'checked' : '' }}>
                      <label class="btn btn-outline-primary" for="difficulty{{ ucfirst($level) }}">
                        {{ ucfirst($level) }}
                      </label>
                    @endforeach
                  </div>
                </div>

                {{-- Preparation Time --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Max Preparation Time</label>
                  <input type="range" class="form-range" name="maxPrepTime" min="5" max="120"
                         value="{{ request('maxPrepTime', 60) }}" id="prepTimeRange">
                  <div class="d-flex justify-content-between">
                    <small>5 min</small>
                    <small id="prepTimeValue">{{ request('maxPrepTime', 60) }} min</small>
                    <small>120 min</small>
                  </div>
                </div>

                {{-- Benefits --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Benefits</label>
                  <div class="d-flex flex-column gap-2">
                    @foreach($benefits ?? [
                      'hydrating' => 'Hydrating',
                      'anti-aging' => 'Anti-Aging',
                      'brightening' => 'Brightening',
                      'acne-fighting' => 'Acne Fighting',
                      'soothing' => 'Soothing',
                      'anti-inflammatory' => 'Anti-Inflammatory'
                    ] as $key => $benefit)
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="benefit[]"
                               value="{{ $key }}" id="benefit{{ $key }}"
                               {{ in_array($key, request('benefit', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="benefit{{ $key }}">
                          {{ $benefit }}
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>

                {{-- Ingredients --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Ingredients</label>
                  <input type="text"
                         name="includeIngredient"
                         class="form-control mb-2"
                         placeholder="Must include..."
                         value="{{ request('includeIngredient') }}">
                  <input type="text"
                         name="excludeIngredient"
                         class="form-control"
                         placeholder="Exclude..."
                         value="{{ request('excludeIngredient') }}">
                </div>

                {{-- Special Filters --}}
                <div class="mb-4">
                  <label class="form-label fw-bold">Special Requirements</label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="vegan" id="veganCheck"
                           {{ request('vegan') ? 'checked' : '' }}>
                    <label class="form-check-label" for="veganCheck">
                      <i class="fas fa-leaf text-success me-1"></i> Vegan Only
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="organic" id="organicCheck"
                           {{ request('organic') ? 'checked' : '' }}>
                    <label class="form-check-label" for="organicCheck">
                      <i class="fas fa-seedling text-success me-1"></i> Organic Ingredients
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck"
                           {{ request('featured') ? 'checked' : '' }}>
                    <label class="form-check-label" for="featuredCheck">
                      <i class="fas fa-star text-warning me-1"></i> Featured Recipes
                    </label>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                  <i class="fas fa-search me-2"></i> Apply Filters
                </button>
              </form>
            </div>
          </div>

          {{-- Quick Tips --}}
          <div class="card shadow-sm border-0 mt-4">
            <div class="card-body">
              <h5 class="fw-bold mb-3">
                <i class="fas fa-lightbulb text-warning me-2"></i> Quick Tips
              </h5>
              <ul class="list-unstyled small">
                <li class="mb-2">
                  <i class="fas fa-check text-success me-2"></i>
                  Always patch test new recipes
                </li>
                <li class="mb-2">
                  <i class="fas fa-check text-success me-2"></i>
                  Store in airtight containers
                </li>
                <li class="mb-2">
                  <i class="fas fa-check text-success me-2"></i>
                  Check ingredient expiration dates
                </li>
                <li class="mb-2">
                  <i class="fas fa-check text-success me-2"></i>
                  Follow usage recommendations
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </aside>

    {{-- MAIN CONTENT AREA --}}
    <main class="col-lg-9">
      {{-- VIEW CONTROLS AND SORTING --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="mb-3 mb-md-0">
              <span class="text-muted me-3">Showing {{ count($recipes ?? []) }} of {{ $totalRecipes ?? '300+' }} recipes</span>

              {{-- Active Filter Tags --}}
              @if(request()->anyFilled(['search', 'skinType', 'difficulty', 'category', 'benefit']))
                <div class="d-inline-flex flex-wrap gap-2">
                  @if(request('search'))
                    <span class="badge bg-secondary d-flex align-items-center">
                      Search: "{{ request('search') }}"
                      <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ms-2">
                        <i class="fas fa-times small"></i>
                      </a>
                    </span>
                  @endif
                  @if(request('skinType'))
                    <span class="badge bg-primary d-flex align-items-center">
                      {{ request('skinType') }}
                      <a href="{{ request()->fullUrlWithQuery(['skinType' => null]) }}" class="text-white ms-2">
                        <i class="fas fa-times small"></i>
                      </a>
                    </span>
                  @endif
                  @if(request('difficulty'))
                    @foreach(request('difficulty', []) as $diff)
                      <span class="badge bg-info d-flex align-items-center">
                        {{ ucfirst($diff) }}
                        <a href="{{ request()->fullUrlWithQuery(['difficulty' => array_diff(request('difficulty', []), [$diff])]) }}" class="text-white ms-2">
                          <i class="fas fa-times small"></i>
                        </a>
                      </span>
                    @endforeach
                  @endif
                  @if(request('category'))
                    <span class="badge bg-warning text-dark d-flex align-items-center">
                      {{ ucfirst(str_replace('_', ' ', request('category'))) }}
                      <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="text-dark ms-2">
                        <i class="fas fa-times small"></i>
                      </a>
                    </span>
                  @endif
                </div>
              @endif
            </div>

            <div class="d-flex align-items-center">
              {{-- Sort By --}}
              <div class="me-3">
                <select name="sortBy" class="form-select form-select-sm" onchange="this.form.submit()">
                  <option value="newest" {{ request('sortBy') == 'newest' ? 'selected' : '' }}>Newest First</option>
                  <option value="likesCount" {{ request('sortBy') == 'likesCount' ? 'selected' : '' }}>Most Liked</option>
                  <option value="commentsCount" {{ request('sortBy') == 'commentsCount' ? 'selected' : '' }}>Most Discussed</option>
                  <option value="viewsCount" {{ request('sortBy') == 'viewsCount' ? 'selected' : '' }}>Most Viewed</option>
                  <option value="rating" {{ request('sortBy') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                  <option value="preparation_time" {{ request('sortBy') == 'preparation_time' ? 'selected' : '' }}>Quickest to Make</option>
                </select>
              </div>

              {{-- View Switcher --}}
              <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="gridView" title="Grid View">
                  <i class="fas fa-th"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="listView" title="List View">
                  <i class="fas fa-list"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="compactView" title="Compact View">
                  <i class="fas fa-grip-horizontal"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- RECIPE GRID --}}
      <div id="recipesContainer">
        @if(session('error'))
          <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
          </div>
        @endif

        @if(isset($recipes) && count($recipes) > 0)
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="recipeGrid">
            @foreach($recipes as $recipe)
              <div class="col recipe-card-col">
                <div class="card h-100 shadow-sm border-0 recipe-card">
                  {{-- Image with Overlay --}}
                  <div class="position-relative overflow-hidden">
                    <img src="{{ $recipe->image_url ?? 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600' }}"
                         class="card-img-top recipe-image"
                         alt="{{ $recipe->title }}"
                         loading="lazy">

                    {{-- Image Overlay with Actions --}}
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-start justify-content-between p-3 recipe-overlay">
                      {{-- Featured Badge --}}
                      @if($recipe->is_featured ?? false)
                        <span class="badge bg-danger">
                          <i class="fas fa-star me-1"></i> Featured
                        </span>
                      @else
                        <span></span>
                      @endif

                      {{-- Quick Actions --}}
                      <div class="d-flex flex-column gap-2">
                        <button class="btn btn-sm btn-light rounded-circle shadow-sm"
                                onclick="toggleFavorite({{ $recipe->id }})"
                                title="Add to favorites">
                          <i class="far fa-heart text-danger"></i>
                        </button>
                        <button class="btn btn-sm btn-light rounded-circle shadow-sm"
                                onclick="quickPreview({{ $recipe->id }})"
                                title="Quick preview">
                          <i class="fas fa-search-plus text-primary"></i>
                        </button>
                      </div>
                    </div>

                    {{-- Preparation Time --}}
                    <div class="position-absolute bottom-0 start-0 m-2">
                      <span class="badge bg-dark bg-opacity-75">
                        <i class="fas fa-clock me-1"></i> {{ $recipe->preparation_time }} min
                      </span>
                    </div>
                  </div>

                  <div class="card-body">
                    {{-- Rating --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <div>
                        @for($i = 0; $i < 5; $i++)
                          <i class="fas fa-star {{ $i < ($recipe->average_rating ?? 4) ? 'text-warning' : 'text-muted' }} small"></i>
                        @endfor
                        <span class="text-muted small ms-1">({{ $recipe->reviews_count ?? 0 }})</span>
                      </div>
                      <span class="badge bg-{{ $recipe->difficulty_level == 'easy' ? 'success' : ($recipe->difficulty_level == 'medium' ? 'warning' : 'danger') }}">
                        {{ ucfirst($recipe->difficulty_level) }}
                      </span>
                    </div>

                    <h5 class="card-title fw-bold">{{ $recipe->title }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($recipe->description, 100) }}</p>

                    {{-- Tags --}}
                    <div class="d-flex flex-wrap gap-2 my-3">
                      <span class="badge bg-primary">
                        <i class="fas fa-user me-1"></i> {{ $recipe->skinType->name ?? 'All Skin Types' }}
                      </span>
                      @if($recipe->vegan ?? false)
                        <span class="badge bg-success">
                          <i class="fas fa-leaf me-1"></i> Vegan
                        </span>
                      @endif
                      @if($recipe->organic ?? false)
                        <span class="badge bg-success">
                          <i class="fas fa-seedling me-1"></i> Organic
                        </span>
                      @endif
                    </div>

                    {{-- Author --}}
                    <div class="d-flex align-items-center mb-3">
                      <img src="{{ $recipe->author_avatar ?? 'https://ui-avatars.com/api/?name=User' }}"
                           class="rounded-circle me-2"
                           width="28"
                           height="28"
                           alt="Author">
                      <small class="text-muted">by {{ $recipe->author_name ?? 'Anonymous' }}</small>
                    </div>
                  </div>

                  {{-- Footer Stats --}}
                  <div class="card-footer bg-white border-0 d-flex justify-content-between small text-muted">
                    <span title="Likes">
                      <i class="fas fa-heart text-danger me-1"></i> {{ $recipe->likes_count ?? 0 }}
                    </span>
                    <span title="Comments">
                      <i class="fas fa-comment text-primary me-1"></i> {{ $recipe->comments_count ?? 0 }}
                    </span>
                    <span title="Saves">
                      <i class="fas fa-bookmark text-success me-1"></i> {{ $recipe->saves_count ?? 0 }}
                    </span>
                    <span title="Views">
                      <i class="fas fa-eye text-info me-1"></i> {{ $recipe->views_count ?? 0 }}
                    </span>
                  </div>

                  {{-- Action Buttons --}}
                  <div class="p-3 pt-0">
                    <div class="d-flex gap-2">
                      <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-eye me-2"></i> View Recipe
                      </a>
                      <button class="btn btn-outline-success" onclick="shareRecipe({{ $recipe->id }})" title="Share">
                        <i class="fas fa-share-alt"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          @if(isset($recipes) && method_exists($recipes, 'links'))
            <div class="mt-5 d-flex justify-content-center">
              {{ $recipes->links() }}
            </div>
          @endif

          {{-- Load More Button --}}
          <div class="text-center mt-4">
            <button class="btn btn-outline-primary btn-lg px-5" onclick="loadMoreRecipes()">
              <i class="fas fa-chevron-down me-2"></i> Load More Recipes
            </button>
          </div>

        @else
          {{-- Empty State --}}
          <div class="text-center py-5">
            <i class="fas fa-search fa-4x text-muted mb-4"></i>
            <h2>No Recipes Found</h2>
            <p class="text-muted mb-4">Try adjusting your filters to find what you're looking for.</p>
            <a href="{{ route('recipes.index') }}" class="btn btn-primary">
              <i class="fas fa-redo me-2"></i> Clear All Filters
            </a>
          </div>
        @endif
      </div>

      {{-- RECOMMENDATIONS SECTION --}}
      @if(isset($recommendedRecipes) && count($recommendedRecipes) > 0)
        <section class="mt-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">
              <i class="fas fa-fire text-warning me-2"></i> Recommended For You
            </h3>
            <a href="#" class="btn btn-sm btn-outline-primary">See All</a>
          </div>

          <div class="row row-cols-2 row-cols-md-4 g-3">
            @foreach($recommendedRecipes as $recipe)
              <div class="col">
                <div class="card border-0 h-100">
                  <img src="{{ $recipe->image_url ?? 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600' }}"
                       class="card-img-top rounded"
                       alt="{{ $recipe->title }}"
                       style="height: 120px; object-fit: cover;">
                  <div class="card-body p-2">
                    <h6 class="card-title mb-1">{{ Str::limit($recipe->title, 30) }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                      <small class="text-muted">{{ $recipe->preparation_time }} min</small>
                      <div>
                        @for($i = 0; $i < 5; $i++)
                          <i class="fas fa-star {{ $i < ($recipe->average_rating ?? 4) ? 'text-warning' : 'text-muted' }}" style="font-size: 0.7rem;"></i>
                        @endfor
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </section>
      @endif
    </main>
  </div>
</div>

{{-- MODALS --}}
{{-- Advanced Filters Modal --}}
<div class="modal fade" id="advancedFiltersModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title">
          <i class="fas fa-sliders-h me-2"></i>Advanced Filters
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form method="GET" action="{{ route('recipes.index') }}" id="advancedFilterForm">
          <div class="row g-4">
            <div class="col-md-6">
              <h6 class="fw-bold text-primary mb-3">
                <i class="fas fa-tags me-2"></i>Categories
              </h6>
              <div class="row g-2">
                @foreach($categories ?? ['face_mask' => 'Face Masks', 'serum' => 'Serums', 'moisturizer' => 'Moisturizers'] as $key => $category)
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="category[]" value="{{ $key }}"
                             id="category{{ $key }}" {{ in_array($key, request('category', [])) ? 'checked' : '' }}>
                      <label class="form-check-label" for="category{{ $key }}">
                        {{ $category }}
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-primary mb-3">
                <i class="fas fa-star me-2"></i>Difficulty Levels
              </h6>
              <div class="row g-2">
                @foreach(['easy', 'medium', 'hard'] as $level)
                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="difficulty[]" value="{{ $level }}"
                             id="difficulty{{ ucfirst($level) }}" {{ in_array($level, request('difficulty', [])) ? 'checked' : '' }}>
                      <label class="form-check-label" for="difficulty{{ ucfirst($level) }}">
                        {{ ucfirst($level) }}
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="col-12">
              <h6 class="fw-bold text-primary mb-3">
                <i class="fas fa-flask me-2"></i>Benefits
              </h6>
              <div class="row g-2">
                @foreach(['hydrating' => 'Hydrating', 'anti-aging' => 'Anti-Aging', 'brightening' => 'Brightening'] as $key => $benefit)
                  <div class="col-md-4 col-sm-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="benefit[]" value="{{ $key }}"
                             id="benefit{{ $key }}" {{ in_array($key, request('benefit', [])) ? 'checked' : '' }}>
                      <label class="form-check-label" for="benefit{{ $key }}">
                        {{ $benefit }}
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-primary mb-3">
                <i class="fas fa-seedling me-2"></i>Special Requirements
              </h6>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="vegan" id="veganCheck"
                       {{ request('vegan') ? 'checked' : '' }}>
                <label class="form-check-label" for="veganCheck">
                  <i class="fas fa-leaf text-success me-1"></i>Vegan Only
                </label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="organic" id="organicCheck"
                       {{ request('organic') ? 'checked' : '' }}>
                <label class="form-check-label" for="organicCheck">
                  <i class="fas fa-seedling text-success me-1"></i>Organic Ingredients
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck"
                       {{ request('featured') ? 'checked' : '' }}>
                <label class="form-check-label" for="featuredCheck">
                  <i class="fas fa-star text-warning me-1"></i>Featured Recipes
                </label>
              </div>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-primary mb-3">
                <i class="fas fa-clock me-2"></i>Preparation Time
              </h6>
              <input type="range" class="form-range" name="maxPrepTime" min="5" max="120"
                     value="{{ request('maxPrepTime', 60) }}" id="prepTimeRange">
              <div class="d-flex justify-content-between text-muted small">
                <span>5 min</span>
                <span id="prepTimeValue">{{ request('maxPrepTime', 60) }} min</span>
                <span>120 min</span>
              </div>
            </div>
          </div>

          <div class="modal-footer border-0 pt-4">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary px-4">
              <i class="fas fa-search me-2"></i>Apply Filters
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Quick Preview Modal --}}
<div class="modal fade" id="quickPreviewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-gradient-primary text-white border-0">
        <h5 class="modal-title">
          <i class="fas fa-eye me-2"></i>Recipe Preview
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="previewContent">
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Save Search Modal --}}
<div class="modal fade" id="saveSearchModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Save This Search</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="saveSearchForm">
          <div class="mb-3">
            <label for="searchName" class="form-label">Search Name</label>
            <input type="text" class="form-control" id="searchName" placeholder="e.g., Quick Vegan Face Masks">
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="emailAlerts">
            <label class="form-check-label" for="emailAlerts">
              Notify me when new recipes match this search
            </label>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveSearch()">Save Search</button>
      </div>
    </div>
  </div>
</div>

{{-- Success Modal for Actions --}}
<div class="modal fade" id="actionSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fas fa-check-circle"></i> Success!</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
        <h5 id="successMessage">Action completed successfully!</h5>
      </div>
    </div>
  </div>
</div>

{{-- Share Toast Notification --}}
<div class="toast position-fixed bottom-0 end-0 m-3" id="shareToast" role="alert">
  <div class="toast-header">
    <i class="fas fa-share-alt text-primary me-2"></i>
    <strong class="me-auto">Share</strong>
    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
  </div>
  <div class="toast-body">
    Recipe link copied to clipboard!
  </div>
</div>

<style>
/* ===== BROWSE RECIPES PAGE STYLES ===== */
:root {
  --primary-green: #4a7c59;
  --primary-green-light: #6b9d7a;
  --primary-green-dark: #3a6547;
  --secondary-pink: #f8a488;
  --accent-purple: #8b5fbf;
  --light-bg: #f8f9fa;
  --white: #ffffff;
  --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
  --shadow-md: 0 4px 12px rgba(0,0,0,0.15);
  --shadow-lg: 0 8px 32px rgba(0,0,0,0.2);
  --border-radius: 12px;
  --border-radius-lg: 16px;
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.container-fluid {
  background-color: var(--light-bg);
}

/* ===== HERO SECTION ===== */
.browse-hero {
  background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-light) 50%, var(--accent-purple) 100%);
  border-radius: 0 0 var(--border-radius-lg) var(--border-radius-lg);
  position: relative;
  overflow: hidden;
  margin-bottom: 3rem;
  box-shadow: var(--shadow-lg);
}

.browse-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image:
    radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(255,255,255,0.05) 0%, transparent 50%);
}

.hero-illustration {
  animation: gentle-float 4s ease-in-out infinite;
  filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
}

@keyframes gentle-float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  33% { transform: translateY(-8px) rotate(1deg); }
  66% { transform: translateY(-4px) rotate(-0.5deg); }
}

/* ===== BREADCRUMB ===== */
.breadcrumb {
  background: transparent;
  padding: 0;
  margin-bottom: 2rem;
}

.breadcrumb-item + .breadcrumb-item::before {
  content: "›";
  color: var(--primary-green);
  font-weight: bold;
  font-size: 1.2rem;
}

.breadcrumb-item a {
  color: var(--primary-green);
  text-decoration: none;
  transition: var(--transition);
}

.breadcrumb-item a:hover {
  color: var(--primary-green-dark);
  transform: translateX(2px);
}

.breadcrumb-item.active {
  color: #6c757d;
  font-weight: 500;
}

/* ===== SEARCH BAR ===== */
.search-bar {
  margin-bottom: 3rem;
}

.search-bar .card {
  border: none;
  border-radius: var(--border-radius-lg);
  background: linear-gradient(135deg, var(--white) 0%, #f8f9fa 100%);
  box-shadow: var(--shadow-md);
  position: relative;
  overflow: hidden;
}

.search-bar .card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--primary-green), var(--primary-green-light), var(--accent-purple));
}

.search-bar .form-label {
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
}

.search-bar .form-control,
.search-bar .form-select {
  border: 2px solid #e9ecef;
  border-radius: var(--border-radius);
  padding: 0.75rem 1rem;
  font-size: 1rem;
  transition: var(--transition);
  background: var(--white);
}

.search-bar .form-control:focus,
.search-bar .form-select:focus {
  border-color: var(--primary-green);
  box-shadow: 0 0 0 0.2rem rgba(74, 124, 89, 0.15);
  transform: translateY(-1px);
}

/* ===== STATS CARDS ===== */
.stats-section {
  margin-bottom: 3rem;
}

.stat-card {
  background: linear-gradient(135deg, var(--white) 0%, #f8f9fa 100%);
  border: none;
  border-radius: var(--border-radius-lg);
  transition: var(--transition);
  position: relative;
  overflow: hidden;
  height: 100%;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--primary-green), var(--primary-green-light));
  transform: scaleX(0);
  transition: var(--transition);
}

.stat-card:hover::before {
  transform: scaleX(1);
}

.stat-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: var(--shadow-lg);
}

.stat-icon {
  transition: var(--transition);
  margin-bottom: 1rem;
}

.stat-card:hover .stat-icon {
  transform: scale(1.1) rotate(5deg);
  color: var(--primary-green) !important;
}

.stat-card .card-body {
  padding: 2rem;
  text-align: center;
}

.stat-card h3 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.stat-card p {
  font-size: 0.9rem;
  color: #6c757d;
  font-weight: 500;
  margin-bottom: 1rem;
}

.stat-card .progress {
  height: 6px;
  border-radius: 3px;
  background: rgba(0,0,0,0.1);
  margin-top: 1rem;
}

.stat-card .progress-bar {
  border-radius: 3px;
  transition: width 1s ease-in-out;
}

/* ===== RECIPE CARDS ===== */
.recipe-card {
  border: none;
  border-radius: var(--border-radius-lg);
  overflow: hidden;
  transition: var(--transition);
  background: var(--white);
  box-shadow: var(--shadow-sm);
  position: relative;
}

.recipe-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--primary-green), var(--secondary-pink));
  transform: scaleX(0);
  transition: var(--transition);
}

.recipe-card:hover::before {
  transform: scaleX(1);
}

.recipe-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: var(--shadow-lg);
}

.recipe-image {
  height: 220px;
  object-fit: cover;
  transition: var(--transition);
}

.recipe-card:hover .recipe-image {
  transform: scale(1.05);
}

.recipe-overlay {
  background: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 70%, transparent 100%);
  opacity: 0;
  transition: var(--transition);
}

.recipe-card:hover .recipe-overlay {
  opacity: 1;
}

.recipe-overlay .btn {
  backdrop-filter: blur(8px);
  background: rgba(255,255,255,0.9);
  border: 1px solid rgba(255,255,255,0.3);
  transition: var(--transition);
}

.recipe-overlay .btn:hover {
  background: var(--white);
  transform: scale(1.05);
}

/* ===== BADGE STYLES ===== */
.badge {
  padding: 0.5rem 1rem;
  border-radius: 50px;
  font-weight: 500;
  letter-spacing: 0.3px;
}

.badge.bg-primary {
  background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light)) !important;
}

/* ===== BUTTON STYLES ===== */
.btn {
  border-radius: var(--border-radius);
  padding: 0.75rem 1.5rem;
  font-weight: 500;
  transition: var(--transition);
  position: relative;
  overflow: hidden;
}

.btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255,255,255,0.2);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: var(--transition);
}

.btn:hover::before {
  width: 300px;
  height: 300px;
}

.btn-primary {
  background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
  border: none;
}

.btn-primary:hover {
  background: linear-gradient(135deg, var(--primary-green-dark), var(--primary-green));
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.btn-outline-primary {
  border-color: var(--primary-green);
  color: var(--primary-green);
}

.btn-outline-primary:hover {
  background: var(--primary-green);
  border-color: var(--primary-green);
  transform: translateY(-2px);
}

/* ===== VIEW STYLES ===== */
.list-view .recipe-card-col {
  flex: 0 0 100%;
  max-width: 100%;
}

.list-view .recipe-card {
  flex-direction: row;
  height: 200px;
}

.list-view .recipe-image {
  width: 200px;
  height: 100%;
  border-radius: 15px 0 0 15px;
}

.compact-view .recipe-card-col {
  flex: 0 0 50%;
  max-width: 50%;
}

.compact-view .recipe-image {
  height: 150px;
}

/* ===== ANIMATIONS ===== */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.recipe-card-col {
  animation: fadeInUp 0.6s ease-out;
  animation-fill-mode: both;
}

.recipe-card-col:nth-child(1) { animation-delay: 0.1s; }
.recipe-card-col:nth-child(2) { animation-delay: 0.2s; }
.recipe-card-col:nth-child(3) { animation-delay: 0.3s; }
.recipe-card-col:nth-child(4) { animation-delay: 0.4s; }
.recipe-card-col:nth-child(5) { animation-delay: 0.5s; }
.recipe-card-col:nth-child(6) { animation-delay: 0.6s; }

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 768px) {
  .browse-hero {
    padding: 3rem 0;
    border-radius: 0 0 20px 20px;
  }

  .browse-hero h1 {
    font-size: 2rem;
  }

  .search-bar .row > div {
    margin-bottom: 1rem;
  }

  .stat-card .card-body {
    padding: 1.5rem;
  }

  .stat-card h3 {
    font-size: 2rem;
  }

  .recipe-image {
    height: 180px;
  }

  .sticky-top {
    position: static !important;
  }

  .list-view .recipe-card {
    flex-direction: column;
    height: auto;
  }

  .list-view .recipe-image {
    width: 100%;
    height: 200px;
    border-radius: 15px 15px 0 0;
  }

  .compact-view .recipe-card-col {
    flex: 0 0 100%;
    max-width: 100%;
  }
}

@media (max-width: 576px) {
  .browse-hero h1 {
    font-size: 1.75rem;
  }

  .search-bar .form-control,
  .search-bar .form-select {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
  }

  .btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
  }
}

/* ===== ACCESSIBILITY ===== */
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}

/* Focus states */
.btn:focus,
.form-control:focus,
.form-select:focus {
  outline: 2px solid var(--primary-green);
  outline-offset: 2px;
}

/* High contrast mode */
@media (prefers-contrast: high) {
  .recipe-card {
    border: 2px solid #000;
  }

  .stat-card {
    border: 2px solid #000;
  }
}
</style>

<script>
// ===== RECIPE BROWSING FEATURES =====

// View Switcher
document.getElementById('gridView')?.addEventListener('click', function() {
  document.getElementById('recipeGrid').className = 'row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4';
  setActiveView(this);
  localStorage.setItem('recipeView', 'grid');
});

document.getElementById('listView')?.addEventListener('click', function() {
  document.getElementById('recipeGrid').className = 'row row-cols-1 g-4 list-view';
  setActiveView(this);
  localStorage.setItem('recipeView', 'list');
});

document.getElementById('compactView')?.addEventListener('click', function() {
  document.getElementById('recipeGrid').className = 'row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 compact-view';
  setActiveView(this);
  localStorage.setItem('recipeView', 'compact');
});

function setActiveView(button) {
  document.querySelectorAll('[id$="View"]').forEach(btn => btn.classList.remove('active'));
  button.classList.add('active');
}

// Filter by skin type
function filterBySkinType(skinType) {
  const url = new URL(window.location);
  url.searchParams.set('skinType', skinType);
  window.location.href = url.toString();
}

// Load saved view preference
document.addEventListener('DOMContentLoaded', function() {
  const savedView = localStorage.getItem('recipeView') || 'grid';
  document.getElementById(savedView + 'View')?.click();

  // Initialize advanced filters modal
  const advancedFiltersModal = document.getElementById('advancedFiltersModal');
  if (advancedFiltersModal) {
    advancedFiltersModal.addEventListener('shown.bs.modal', function() {
      // Update range slider value display
      const prepTimeRange = document.getElementById('prepTimeRange');
      const prepTimeValue = document.getElementById('prepTimeValue');
      if (prepTimeRange && prepTimeValue) {
        prepTimeRange.addEventListener('input', function() {
          prepTimeValue.textContent = this.value + ' min';
        });
      }
    });
  }

  // Add click handlers for skin type cards
  document.querySelectorAll('.skin-type-card').forEach(card => {
    card.addEventListener('click', function() {
      const skinType = this.querySelector('h5').textContent.trim();
      filterBySkinType(skinType);
    });
  });

  // Add hover effects for skin type cards
  document.querySelectorAll('.skin-type-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-8px) scale(1.05)';
      this.style.boxShadow = 'var(--shadow-lg)';
    });

    card.addEventListener('mouseleave', function() {
      this.style.transform = '';
      this.style.boxShadow = '';
    });
  });
});

// Preparation time range display
const prepTimeRange = document.getElementById('prepTimeRange');
const prepTimeValue = document.getElementById('prepTimeValue');
if (prepTimeRange && prepTimeValue) {
  prepTimeRange.addEventListener('input', function() {
    prepTimeValue.textContent = this.value + ' min';
  });
}

// Toggle Favorite
function toggleFavorite(recipeId) {
  fetch(`/api/recipes/${recipeId}/favorite`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
  .then(response => response.json())
  .then(data => {
    console.log('Favorite toggled:', data);
    showSuccess('Recipe added to favorites! 💖');
  })
  .catch(error => console.error('Error:', error));
}

// Quick Preview
function quickPreview(recipeId) {
  const modal = new bootstrap.Modal(document.getElementById('quickPreviewModal'));
  modal.show();

  fetch(`/api/recipes/${recipeId}/preview`)
    .then(response => response.json())
    .then(data => {
      document.getElementById('previewContent').innerHTML = `
        <div class="row">
          <div class="col-md-5">
            <img src="${data.image_url}" class="img-fluid rounded" alt="${data.title}">
          </div>
          <div class="col-md-7">
            <h3>${data.title}</h3>
            <p class="text-muted">${data.description}</p>
            <div class="mb-3">
              <span class="badge bg-primary me-2">${data.skin_type}</span>
              <span class="badge bg-secondary me-2">${data.difficulty_level}</span>
              <span class="badge bg-warning text-dark">${data.preparation_time} min</span>
            </div>
            <div class="mb-3">
              <h6>Key Ingredients:</h6>
              <p class="small">${data.key_ingredients || 'Aloe Vera, Honey, Oatmeal'}</p>
            </div>
            <a href="/recipes/${recipeId}" class="btn btn-primary">View Full Recipe</a>
          </div>
        </div>
      `;
    })
    .catch(error => {
      document.getElementById('previewContent').innerHTML = '<div class="alert alert-danger">Failed to load preview</div>';
    });
}

// Share Recipe
function shareRecipe(recipeId) {
  if (navigator.share) {
    navigator.share({
      title: 'Check out this recipe!',
      text: 'I found this amazing natural skincare recipe',
      url: `/recipes/${recipeId}`
    });
  } else {
    navigator.clipboard.writeText(window.location.origin + `/recipes/${recipeId}`)
      .then(() => {
        const toast = new bootstrap.Toast(document.getElementById('shareToast'));
        toast.show();
      })
      .catch(err => {
        console.error('Failed to copy: ', err);
      });
  }
}

// Save Search
function saveSearch() {
  const searchName = document.getElementById('searchName').value;
  const emailAlerts = document.getElementById('emailAlerts').checked;

  console.log('Saving search:', { searchName, emailAlerts });

  const modal = bootstrap.Modal.getInstance(document.getElementById('saveSearchModal'));
  modal.hide();

  showSuccess('Search saved successfully! 🔍');
}

// Load More Recipes
function loadMoreRecipes() {
  console.log('Loading more recipes...');
  showSuccess('Loading more recipes...');
}

// Show success message
function showSuccess(message) {
  document.getElementById('successMessage').textContent = message;
  new bootstrap.Modal(document.getElementById('actionSuccessModal')).show();
}

// Auto-submit form on filter change
document.querySelectorAll('#filterForm select, #filterForm input[type="radio"]').forEach(element => {
  element.addEventListener('change', function() {
    document.getElementById('filterForm').submit();
  });
});
</script>
@endsection