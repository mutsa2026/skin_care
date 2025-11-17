@extends('layout')

@section('title', 'Browse Recipes | Natural Skincare Community')

@section('content')
<div class="browse-recipes-page">
  {{-- HERO SECTION --}}
  <section class="hero-section">
    <div class="hero-background">
      <div class="hero-pattern"></div>
      <div class="hero-glow"></div>
    </div>
    <div class="container">
      <div class="hero-content">
        <div class="hero-text">
          <span class="hero-badge">
            <i class="fas fa-leaf"></i>
            Natural & Organic
          </span>
          <h1 class="hero-title">
            Discover Your Perfect
            <span class="gradient-text">Skincare Recipe</span>
          </h1>
          <p class="hero-description">
            Explore {{ $totalRecipes ?? '300+' }} handcrafted natural skincare recipes.
            From rejuvenating face masks to nourishing serums—your journey to radiant skin starts here.
          </p>
          <div class="hero-actions">
            <button class="btn btn-primary btn-hero" onclick="document.getElementById('searchInput').focus()">
              <i class="fas fa-search"></i>
              Start Exploring
            </button>
            <button class="btn btn-outline btn-hero" data-bs-toggle="modal" data-bs-target="#advancedFiltersModal">
              <i class="fas fa-sliders-h"></i>
              Advanced Filters
            </button>
          </div>
          <div class="hero-stats">
            <div class="stat-item">
              <span class="stat-value">{{ \App\Models\Recipe::count() }}+</span>
              <span class="stat-label">Recipes</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
              <span class="stat-value">{{ \App\Models\Recipe::where('vegan', true)->count() }}+</span>
              <span class="stat-label">Vegan</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
              <span class="stat-value">6</span>
              <span class="stat-label">Skin Types</span>
            </div>
          </div>
        </div>
        <div class="hero-visual">
          <div class="floating-card card-1">
            <i class="fas fa-spa"></i>
          </div>
          <div class="floating-card card-2">
            <i class="fas fa-seedling"></i>
          </div>
          <div class="floating-card card-3">
            <i class="fas fa-heart"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- SKIN TYPE SELECTOR --}}
  <section class="skin-type-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Find Your Match</h2>
        <p class="section-subtitle">Personalized recipes for every skin type</p>
      </div>
      <div class="skin-type-grid">
        @php
          $skinTypeData = [
            ['name' => 'Dry', 'icon' => 'fa-droplet', 'color' => 'blue', 'desc' => 'Deep hydration'],
            ['name' => 'Oily', 'icon' => 'fa-sun', 'color' => 'yellow', 'desc' => 'Oil control'],
            ['name' => 'Combination', 'icon' => 'fa-yin-yang', 'color' => 'purple', 'desc' => 'Balanced care'],
            ['name' => 'Sensitive', 'icon' => 'fa-hand-holding-heart', 'color' => 'pink', 'desc' => 'Gentle soothing'],
            ['name' => 'Normal', 'icon' => 'fa-smile', 'color' => 'green', 'desc' => 'Maintenance'],
            ['name' => 'Acne-Prone', 'icon' => 'fa-shield-halved', 'color' => 'red', 'desc' => 'Clear & heal'],
          ];
        @endphp
        @foreach($skinTypeData as $type)
          <div class="skin-type-card" onclick="filterBySkinType('{{ $type['name'] }}')">
            <div class="skin-type-icon {{ $type['color'] }}">
              <i class="fas {{ $type['icon'] }}"></i>
            </div>
            <h3 class="skin-type-name">{{ $type['name'] }}</h3>
            <p class="skin-type-desc">{{ $type['desc'] }}</p>
            <span class="skin-type-count">
              {{ \App\Models\Recipe::whereHas('skinType', function($q) use ($type) { $q->where('name', $type['name']); })->count() }} recipes
            </span>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- SEARCH & FILTER BAR --}}
  <section class="search-section">
    <div class="container">
      <div class="search-wrapper">
        <form method="GET" action="{{ route('recipes.index') }}" class="search-form">
          <div class="search-input-group">
            <i class="fas fa-search search-icon"></i>
            <input 
              type="text" 
              class="search-input" 
              id="searchInput"
              name="search" 
              placeholder="Search by name, ingredient, or benefit..."
              value="{{ request('search') }}"
            >
            <button type="submit" class="search-btn">
              Search
            </button>
          </div>
          <div class="quick-filters">
            <select name="maxPrepTime" class="filter-select">
              <option value="">Any Time</option>
              <option value="15" {{ request('maxPrepTime') == '15' ? 'selected' : '' }}>≤ 15 min</option>
              <option value="30" {{ request('maxPrepTime') == '30' ? 'selected' : '' }}>≤ 30 min</option>
              <option value="60" {{ request('maxPrepTime') == '60' ? 'selected' : '' }}>≤ 1 hour</option>
            </select>
            <button type="button" class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#filterPanel">
              <i class="fas fa-filter"></i>
              Filters
              @if(request()->anyFilled(['skinType', 'difficulty', 'category', 'benefit']))
                <span class="filter-badge">{{ count(array_filter([request('skinType'), request('difficulty'), request('category'), request('benefit')])) }}</span>
              @endif
            </button>
          </div>
        </form>
      </div>

      {{-- COLLAPSIBLE FILTER PANEL --}}
      <div class="collapse" id="filterPanel">
        <div class="filter-panel">
          <form method="GET" action="{{ route('recipes.index') }}">
            <div class="filter-grid">
              {{-- Categories --}}
              <div class="filter-group">
                <label class="filter-label">Category</label>
                <div class="filter-options">
                  @foreach(['face_mask' => 'Face Masks', 'serum' => 'Serums', 'moisturizer' => 'Moisturizers', 'cleanser' => 'Cleansers'] as $key => $category)
                    <label class="filter-chip">
                      <input type="radio" name="category" value="{{ $key }}" {{ request('category') == $key ? 'checked' : '' }}>
                      <span>{{ $category }}</span>
                    </label>
                  @endforeach
                </div>
              </div>

              {{-- Difficulty --}}
              <div class="filter-group">
                <label class="filter-label">Difficulty</label>
                <div class="filter-options">
                  @foreach(['easy', 'medium', 'hard'] as $level)
                    <label class="filter-chip">
                      <input type="checkbox" name="difficulty[]" value="{{ $level }}" {{ in_array($level, request('difficulty', [])) ? 'checked' : '' }}>
                      <span>{{ ucfirst($level) }}</span>
                    </label>
                  @endforeach
                </div>
              </div>

              {{-- Special Requirements --}}
              <div class="filter-group">
                <label class="filter-label">Special</label>
                <div class="filter-options">
                  <label class="filter-chip">
                    <input type="checkbox" name="vegan" {{ request('vegan') ? 'checked' : '' }}>
                    <span><i class="fas fa-leaf"></i> Vegan</span>
                  </label>
                  <label class="filter-chip">
                    <input type="checkbox" name="organic" {{ request('organic') ? 'checked' : '' }}>
                    <span><i class="fas fa-seedling"></i> Organic</span>
                  </label>
                  <label class="filter-chip">
                    <input type="checkbox" name="featured" {{ request('featured') ? 'checked' : '' }}>
                    <span><i class="fas fa-star"></i> Featured</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="filter-actions">
              <a href="{{ route('recipes.index') }}" class="btn btn-outline-sm">Reset</a>
              <button type="submit" class="btn btn-primary-sm">Apply Filters</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  {{-- RESULTS SECTION --}}
  <section class="results-section">
    <div class="container">
      {{-- Results Header --}}
      <div class="results-header">
        <div class="results-info">
          <h3 class="results-title">{{ count($recipes ?? []) }} Recipes Found</h3>
          {{-- Active Filters --}}
          @if(request()->anyFilled(['search', 'skinType', 'difficulty', 'category']))
            <div class="active-filters">
              @if(request('search'))
                <span class="filter-tag">
                  "{{ request('search') }}"
                  <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}">×</a>
                </span>
              @endif
              @if(request('skinType'))
                <span class="filter-tag">
                  {{ request('skinType') }}
                  <a href="{{ request()->fullUrlWithQuery(['skinType' => null]) }}">×</a>
                </span>
              @endif
            </div>
          @endif
        </div>
        <div class="results-controls">
          <select name="sortBy" class="sort-select" onchange="window.location.href='?sortBy='+this.value">
            <option value="newest" {{ request('sortBy') == 'newest' ? 'selected' : '' }}>Latest</option>
            <option value="likesCount" {{ request('sortBy') == 'likesCount' ? 'selected' : '' }}>Most Loved</option>
            <option value="rating" {{ request('sortBy') == 'rating' ? 'selected' : '' }}>Top Rated</option>
            <option value="preparation_time" {{ request('sortBy') == 'preparation_time' ? 'selected' : '' }}>Quickest</option>
          </select>
          <div class="view-switcher">
            <button class="view-btn active" id="gridView" title="Grid View">
              <i class="fas fa-grip"></i>
            </button>
            <button class="view-btn" id="listView" title="List View">
              <i class="fas fa-list"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- Recipe Grid --}}
      @if(isset($recipes) && count($recipes) > 0)
        <div class="recipe-grid" id="recipeGrid">
          @foreach($recipes as $recipe)
            <article class="recipe-card">
              <div class="recipe-image-wrapper">
                <img 
                  src="{{ $recipe->image_url ?? 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600' }}" 
                  alt="{{ $recipe->title }}"
                  class="recipe-image"
                  loading="lazy"
                >
                <div class="recipe-overlay">
                  <button class="icon-btn" onclick="toggleFavorite({{ $recipe->id }})" title="Save">
                    <i class="far fa-heart"></i>
                  </button>
                  <button class="icon-btn" onclick="quickPreview({{ $recipe->id }})" title="Preview">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                @if($recipe->is_featured ?? false)
                  <span class="recipe-badge featured">
                    <i class="fas fa-star"></i> Featured
                  </span>
                @endif
                <span class="recipe-badge time">
                  <i class="fas fa-clock"></i> {{ $recipe->preparation_time }}m
                </span>
              </div>

              <div class="recipe-content">
                <div class="recipe-meta">
                  <div class="recipe-rating">
                    @for($i = 0; $i < 5; $i++)
                      <i class="fas fa-star {{ $i < ($recipe->average_rating ?? 4) ? 'active' : '' }}"></i>
                    @endfor
                    <span>({{ $recipe->reviews_count ?? 0 }})</span>
                  </div>
                  <span class="difficulty-badge {{ $recipe->difficulty_level }}">
                    {{ ucfirst($recipe->difficulty_level) }}
                  </span>
                </div>

                <h3 class="recipe-title">{{ $recipe->title }}</h3>
                <p class="recipe-description">{{ Str::limit($recipe->description, 80) }}</p>

                <div class="recipe-tags">
                  <span class="tag primary">
                    <i class="fas fa-user"></i>
                    {{ $recipe->skinType->name ?? 'All Types' }}
                  </span>
                  @if($recipe->vegan ?? false)
                    <span class="tag success">
                      <i class="fas fa-leaf"></i> Vegan
                    </span>
                  @endif
                </div>

                <div class="recipe-author">
                  <img src="{{ $recipe->author_avatar ?? 'https://ui-avatars.com/api/?name=User' }}" alt="Author">
                  <span>{{ $recipe->author_name ?? 'Anonymous' }}</span>
                </div>

                <div class="recipe-stats">
                  <span><i class="fas fa-heart"></i> {{ $recipe->likes_count ?? 0 }}</span>
                  <span><i class="fas fa-comment"></i> {{ $recipe->comments_count ?? 0 }}</span>
                  <span><i class="fas fa-eye"></i> {{ $recipe->views_count ?? 0 }}</span>
                </div>

                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-primary btn-full">
                  View Recipe
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </article>
          @endforeach
        </div>

        {{-- Pagination --}}
        @if(isset($recipes) && method_exists($recipes, 'links'))
          <div class="pagination-wrapper">
            {{ $recipes->links() }}
          </div>
        @endif

      @else
        {{-- Empty State --}}
        <div class="empty-state">
          <div class="empty-icon">
            <i class="fas fa-search"></i>
          </div>
          <h2>No Recipes Found</h2>
          <p>Try adjusting your filters or search terms</p>
          <a href="{{ route('recipes.index') }}" class="btn btn-primary">
            <i class="fas fa-redo"></i>
            Clear Filters
          </a>
        </div>
      @endif
    </div>
  </section>
</div>

{{-- MODALS --}}
{{-- Quick Preview Modal --}}
<div class="modal fade" id="quickPreviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Recipe Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="previewContent">
        <div class="text-center py-5">
          <div class="spinner-border text-primary"></div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Advanced Filters Modal --}}
<div class="modal fade" id="advancedFiltersModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Advanced Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="GET" action="{{ route('recipes.index') }}">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-bold">Categories</label>
              <div class="d-flex flex-wrap gap-2">
                @foreach(['face_mask' => 'Face Masks', 'serum' => 'Serums', 'moisturizer' => 'Moisturizers'] as $key => $category)
                  <label class="filter-chip">
                    <input type="checkbox" name="category[]" value="{{ $key }}">
                    <span>{{ $category }}</span>
                  </label>
                @endforeach
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Benefits</label>
              <div class="d-flex flex-wrap gap-2">
                @foreach(['hydrating' => 'Hydrating', 'anti-aging' => 'Anti-Aging', 'brightening' => 'Brightening'] as $key => $benefit)
                  <label class="filter-chip">
                    <input type="checkbox" name="benefit[]" value="{{ $key }}">
                    <span>{{ $benefit }}</span>
                  </label>
                @endforeach
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Apply Filters</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
/* ===== MODERN CSS VARIABLES ===== */
:root {
  --primary: #2d6a4f;
  --primary-light: #40916c;
  --primary-dark: #1b4332;
  --secondary: #f4a261;
  --accent: #e76f51;
  --purple: #9d4edd;
  --blue: #4361ee;
  --success: #52b788;
  --warning: #f4a261;
  --danger: #e63946;
  
  --gray-50: #f8f9fa;
  --gray-100: #f1f3f5;
  --gray-200: #e9ecef;
  --gray-300: #dee2e6;
  --gray-400: #ced4da;
  --gray-500: #adb5bd;
  --gray-600: #6c757d;
  --gray-700: #495057;
  --gray-800: #343a40;
  --gray-900: #212529;
  
  --white: #ffffff;
  --black: #000000;
  
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-xl: 24px;
  --radius-full: 9999px;
  
  --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
  --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.15);
  --shadow-xl: 0 20px 50px rgba(0, 0, 0, 0.2);
  
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  --transition-fast: all 0.15s ease;
}

/* ===== GLOBAL STYLES ===== */
.browse-recipes-page {
  background: linear-gradient(to bottom, var(--gray-50), var(--white));
  min-height: 100vh;
}

/* ===== HERO SECTION ===== */
.hero-section {
  position: relative;
  padding: 80px 0 120px;
  overflow: hidden;
  background: linear-gradient(135deg, #1e3a2f 0%, #2d6a4f 50%, #40916c 100%);
}

.hero-background {
  position: absolute;
  inset: 0;
  overflow: hidden;
}

.hero-pattern {
  position: absolute;
  inset: 0;
  background-image: 
    radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.06) 0%, transparent 50%);
  animation: patternShift 20s ease-in-out infinite;
}

.hero-glow {
  position: absolute;
  top: -50%;
  right: -20%;
  width: 800px;
  height: 800px;
  background: radial-gradient(circle, rgba(157, 78, 221, 0.3) 0%, transparent 70%);
  filter: blur(80px);
  animation: glowPulse 8s ease-in-out infinite;
}

@keyframes patternShift {
  0%, 100% { transform: translate(0, 0); }
  50% { transform: translate(20px, 20px); }
}

@keyframes glowPulse {
  0%, 100% { opacity: 0.5; transform: scale(1); }
  50% { opacity: 0.8; transform: scale(1.1); }
}

.hero-content {
  position: relative;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 20px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border-radius: var(--radius-full);
  color: var(--white);
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 24px;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 800;
  line-height: 1.1;
  color: var(--white);
  margin-bottom: 24px;
  letter-spacing: -0.02em;
}

.gradient-text {
  display: block;
  background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-description {
  font-size: 1.125rem;
  line-height: 1.7;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 32px;
  max-width: 540px;
}

.hero-actions {
  display: flex;
  gap: 16px;
  margin-bottom: 48px;
}

.btn-hero {
  padding: 14px 32px;
  font-size: 1rem;
  font-weight: 600;
  border-radius: var(--radius-lg);
  transition: var(--transition);
}

.btn-primary {
  background: var(--white);
  color: var(--primary);
  border: none;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.btn-outline {
  background: transparent;
  color: var(--white);
  border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-outline:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: var(--white);
}

.hero-stats {
  display: flex;
  gap: 24px;
  align-items: center;
}

.stat-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: var(--white);
}

.stat-label {
  font-size: 0.875rem;
  color: rgba(255, 255, 255, 0.7);
}

.stat-divider {
  width: 1px;
  height: 40px;
  background: rgba(255, 255, 255, 0.3);
}

/* Hero Visual */
.hero-visual {
  position: relative;
  height: 400px;
}

.floating-card {
  position: absolute;
  width: 120px;
  height: 120px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-xl);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  color: var(--white);
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.card-1 {
  top: 20%;
  left: 10%;
  animation: float 6s ease-in-out infinite;
}

.card-2 {
  top: 50%;
  right: 20%;
  animation: float 8s ease-in-out infinite 1s;
}

.card-3 {
  bottom: 10%;
  left: 40%;
  animation: float 7s ease-in-out infinite 2s;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(5deg); }
}

/* ===== SKIN TYPE SECTION ===== */
.skin-type-section {
  padding: 80px 0;
  background: var(--white);
}

.section-header {
  text-align: center;
  margin-bottom: 60px;
}

.section-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--gray-900);
  margin-bottom: 12px;
}

.section-subtitle {
  font-size: 1.125rem;
  color: var(--gray-600);
}

.skin-type-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 24px;
}

.skin-type-card {
  background: var(--white);
  border-radius: var(--radius-xl);
  padding: 32px 24px;
  text-align: center;
  cursor: pointer;
  transition: var(--transition);
  border: 2px solid var(--gray-200);
  position: relative;
  overflow: hidden;
}

.skin-type-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--primary), var(--secondary));
  transform: scaleX(0);
  transition: var(--transition);
}

.skin-type-card:hover::before {
  transform: scaleX(1);
}

.skin-type-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
  border-color: var(--primary-light);
}

.skin-type-icon {
  width: 80px;
  height: 80px;
  border-radius: var(--radius-full);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
  font-size: 2rem;
  transition: var(--transition);
}

.skin-type-icon.blue { background: linear-gradient(135deg, #4361ee, #7209b7); color: var(--white); }
.skin-type-icon.yellow { background: linear-gradient(135deg, #f4a261, #e76f51); color: var(--white); }
.skin-type-icon.purple { background: linear-gradient(135deg, #9d4edd, #c77dff); color: var(--white); }
.skin-type-icon.pink { background: linear-gradient(135deg, #ff006e, #fb5607); color: var(--white); }
.skin-type-icon.green { background: linear-gradient(135deg, #52b788, #2d6a4f); color: var(--white); }
.skin-type-icon.red { background: linear-gradient(135deg, #e63946, #d62828); color: var(--white); }

.skin-type-card:hover .skin-type-icon {
  transform: scale(1.1) rotate(5deg);
}

.skin-type-name {
  font-size: 1.125rem;
  font-weight: 600;
  color: var(--gray-900);
  margin-bottom: 8px;
}

.skin-type-desc {
  font-size: 0.875rem;
  color: var(--gray-600);
  margin-bottom: 12px;
}

.skin-type-count {
  display: inline-block;
  padding: 4px 12px;
  background: var(--gray-100);
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 600;
  color: var(--gray-700);
}

/* ===== SEARCH SECTION ===== */
.search-section {
  padding: 60px 0;
  background: var(--gray-50);
}

.search-wrapper {
  background: var(--white);
  border-radius: var(--radius-xl);
  padding: 32px;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--gray-200);
}

.search-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.search-input-group {
  position: relative;
  display: flex;
  align-items: center;
  gap: 12px;
}

.search-icon {
  position: absolute;
  left: 20px;
  color: var(--gray-500);
  font-size: 1.25rem;
  pointer-events: none;
}

.search-input {
  flex: 1;
  padding: 16px 20px 16px 56px;
  border: 2px solid var(--gray-300);
  border-radius: var(--radius-lg);
  font-size: 1rem;
  transition: var(--transition);
  background: var(--white);
}

.search-input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(45, 106, 79, 0.1);
}

.search-btn {
  padding: 16px 32px;
  background: linear-gradient(135deg, var(--primary), var(--primary-light));
  color: var(--white);
  border: none;
  border-radius: var(--radius-lg);
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  white-space: nowrap;
}

.search-btn:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.quick-filters {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.filter-select {
  padding: 12px 16px;
  border: 2px solid var(--gray-300);
  border-radius: var(--radius-md);
  background: var(--white);
  font-size: 0.875rem;
  cursor: pointer;
  transition: var(--transition);
}

.filter-select:focus {
  outline: none;
  border-color: var(--primary);
}

.filter-toggle {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 20px;
  background: var(--white);
  border: 2px solid var(--gray-300);
  border-radius: var(--radius-md);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition);
  position: relative;
}

.filter-toggle:hover {
  border-color: var(--primary);
  color: var(--primary);
}

.filter-badge {
  position: absolute;
  top: -8px;
  right: -8px;
  width: 24px;
  height: 24px;
  background: var(--accent);
  color: var(--white);
  border-radius: var(--radius-full);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: 700;
  border: 2px solid var(--white);
}

/* ===== FILTER PANEL ===== */
.filter-panel {
  margin-top: 20px;
  padding: 24px;
  background: var(--white);
  border-radius: var(--radius-lg);
  border: 2px solid var(--gray-200);
}

.filter-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 24px;
  margin-bottom: 24px;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.filter-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--gray-700);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.filter-options {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.filter-chip {
  position: relative;
  cursor: pointer;
}

.filter-chip input {
  position: absolute;
  opacity: 0;
  pointer-events: none;
}

.filter-chip span {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  background: var(--gray-100);
  border: 2px solid transparent;
  border-radius: var(--radius-full);
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--gray-700);
  transition: var(--transition);
}

.filter-chip:hover span {
  background: var(--gray-200);
}

.filter-chip input:checked + span {
  background: var(--primary);
  color: var(--white);
  border-color: var(--primary);
}

.filter-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding-top: 24px;
  border-top: 1px solid var(--gray-200);
}

.btn-outline-sm,
.btn-primary-sm {
  padding: 10px 24px;
  border-radius: var(--radius-md);
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.btn-outline-sm {
  background: transparent;
  border: 2px solid var(--gray-300);
  color: var(--gray-700);
}

.btn-outline-sm:hover {
  border-color: var(--gray-400);
  background: var(--gray-100);
}

.btn-primary-sm {
  background: var(--primary);
  border: none;
  color: var(--white);
}

.btn-primary-sm:hover {
  background: var(--primary-dark);
  transform: translateY(-2px);
  box-shadow: var(--shadow-sm);
}

/* ===== RESULTS SECTION ===== */
.results-section {
  padding: 60px 0 100px;
}

.results-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
  flex-wrap: wrap;
  gap: 20px;
}

.results-info {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.results-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--gray-900);
}

.active-filters {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.filter-tag {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 6px 12px;
  background: var(--primary-light);
  color: var(--white);
  border-radius: var(--radius-full);
  font-size: 0.875rem;
  font-weight: 500;
}

.filter-tag a {
  color: var(--white);
  text-decoration: none;
  font-weight: 700;
  font-size: 1.25rem;
  line-height: 1;
  opacity: 0.8;
  transition: var(--transition);
}

.filter-tag a:hover {
  opacity: 1;
  transform: scale(1.2);
}

.results-controls {
  display: flex;
  align-items: center;
  gap: 16px;
}

.sort-select {
  padding: 10px 16px;
  border: 2px solid var(--gray-300);
  border-radius: var(--radius-md);
  background: var(--white);
  font-size: 0.875rem;
  cursor: pointer;
  transition: var(--transition);
}

.sort-select:focus {
  outline: none;
  border-color: var(--primary);
}

.view-switcher {
  display: flex;
  gap: 4px;
  background: var(--gray-100);
  padding: 4px;
  border-radius: var(--radius-md);
}

.view-btn {
  padding: 8px 12px;
  background: transparent;
  border: none;
  border-radius: var(--radius-sm);
  color: var(--gray-600);
  cursor: pointer;
  transition: var(--transition);
}

.view-btn:hover {
  color: var(--gray-900);
}

.view-btn.active {
  background: var(--white);
  color: var(--primary);
  box-shadow: var(--shadow-sm);
}

/* ===== RECIPE GRID ===== */
.recipe-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 32px;
}

.recipe-card {
  background: var(--white);
  border-radius: var(--radius-xl);
  overflow: hidden;
  transition: var(--transition);
  border: 1px solid var(--gray-200);
  display: flex;
  flex-direction: column;
}

.recipe-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-xl);
  border-color: var(--primary-light);
}

.recipe-image-wrapper {
  position: relative;
  overflow: hidden;
  height: 240px;
}

.recipe-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: var(--transition);
}

.recipe-card:hover .recipe-image {
  transform: scale(1.05);
}

.recipe-overlay {
  position: absolute;
  top: 16px;
  right: 16px;
  display: flex;
  gap: 8px;
  opacity: 0;
  transform: translateY(-10px);
  transition: var(--transition);
}

.recipe-card:hover .recipe-overlay {
  opacity: 1;
  transform: translateY(0);
}

.icon-btn {
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border: none;
  border-radius: var(--radius-full);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--gray-700);
  cursor: pointer;
  transition: var(--transition);
  box-shadow: var(--shadow-sm);
}

.icon-btn:hover {
  transform: scale(1.1);
  background: var(--white);
  color: var(--accent);
}

.recipe-badge {
  position: absolute;
  padding: 6px 12px;
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 600;
  backdrop-filter: blur(10px);
  display: flex;
  align-items: center;
  gap: 6px;
}

.recipe-badge.featured {
  top: 16px;
  left: 16px;
  background: linear-gradient(135deg, #f4a261, #e76f51);
  color: var(--white);
}

.recipe-badge.time {
  bottom: 16px;
  left: 16px;
  background: rgba(0, 0, 0, 0.75);
  color: var(--white);
}

.recipe-content {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  flex: 1;
}

.recipe-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.recipe-rating {
  display: flex;
  align-items: center;
  gap: 4px;
}

.recipe-rating i {
  font-size: 0.875rem;
  color: var(--gray-300);
}

.recipe-rating i.active {
  color: var(--warning);
}

.recipe-rating span {
  font-size: 0.75rem;
  color: var(--gray-600);
  margin-left: 4px;
}

.difficulty-badge {
  padding: 4px 12px;
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.difficulty-badge.easy {
  background: rgba(82, 183, 136, 0.15);
  color: var(--success);
}

.difficulty-badge.medium {
  background: rgba(244, 162, 97, 0.15);
  color: var(--warning);
}

.difficulty-badge.hard {
  background: rgba(230, 57, 70, 0.15);
  color: var(--danger);
}

.recipe-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--gray-900);
  line-height: 1.3;
  margin: 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.recipe-description {
  font-size: 0.875rem;
  color: var(--gray-600);
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.recipe-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.tag {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 500;
}

.tag.primary {
  background: rgba(45, 106, 79, 0.1);
  color: var(--primary);
}

.tag.success {
  background: rgba(82, 183, 136, 0.1);
  color: var(--success);
}

.recipe-author {
  display: flex;
  align-items: center;
  gap: 10px;
  padding-top: 12px;
  border-top: 1px solid var(--gray-200);
}

.recipe-author img {
  width: 32px;
  height: 32px;
  border-radius: var(--radius-full);
  object-fit: cover;
}

.recipe-author span {
  font-size: 0.875rem;
  color: var(--gray-700);
  font-weight: 500;
}

.recipe-stats {
  display: flex;
  justify-content: space-around;
  padding: 12px 0;
  border-top: 1px solid var(--gray-200);
}

.recipe-stats span {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 0.875rem;
  color: var(--gray-600);
}

.recipe-stats i {
  font-size: 1rem;
}

.btn-full {
  width: 100%;
  padding: 12px;
  background: linear-gradient(135deg, var(--primary), var(--primary-light));
  color: var(--white);
  border: none;
  border-radius: var(--radius-lg);
  font-weight: 600;
  text-align: center;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  transition: var(--transition);
}

.btn-full:hover {
  background: linear-gradient(135deg, var(--primary-dark), var(--primary));
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
  color: var(--white);
}

/* ===== EMPTY STATE ===== */
.empty-state {
  text-align: center;
  padding: 80px 20px;
}

.empty-icon {
  width: 120px;
  height: 120px;
  margin: 0 auto 32px;
  background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
  border-radius: var(--radius-full);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  color: var(--gray-400);
}

.empty-state h2 {
  font-size: 2rem;
  font-weight: 700;
  color: var(--gray-900);
  margin-bottom: 16px;
}

.empty-state p {
  font-size: 1.125rem;
  color: var(--gray-600);
  margin-bottom: 32px;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1200px) {
  .hero-content {
    grid-template-columns: 1fr;
  }
  
  .hero-visual {
    display: none;
  }
}

@media (max-width: 768px) {
  .hero-section {
    padding: 60px 0 80px;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .hero-actions {
    flex-direction: column;
  }
  
  .btn-hero {
    width: 100%;
  }
  
  .skin-type-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .search-input-group {
    flex-direction: column;
  }
  
  .search-input {
    padding-left: 20px;
  }
  
  .search-icon {
    display: none;
  }
  
  .recipe-grid {
    grid-template-columns: 1fr;
  }
  
  .results-header {
    flex-direction: column;
    align-items: flex-start;
  }
}

@media (max-width: 480px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .section-title {
    font-size: 2rem;
  }
  
  .skin-type-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<script>
// ===== VIEW SWITCHER =====
const gridView = document.getElementById('gridView');
const listView = document.getElementById('listView');
const recipeGrid = document.getElementById('recipeGrid');

if (gridView && listView && recipeGrid) {
  gridView.addEventListener('click', function() {
    recipeGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
    recipeGrid.style.gap = '32px';
    gridView.classList.add('active');
    listView.classList.remove('active');
    localStorage.setItem('recipeView', 'grid');
  });

  listView.addEventListener('click', function() {
    recipeGrid.style.gridTemplateColumns = '1fr';
    recipeGrid.style.gap = '24px';
    listView.classList.add('active');
    gridView.classList.remove('active');
    localStorage.setItem('recipeView', 'list');
  });

  // Load saved view
  const savedView = localStorage.getItem('recipeView');
  if (savedView === 'list') {
    listView.click();
  }
}

// ===== FILTER BY SKIN TYPE =====
function filterBySkinType(skinType) {
  const url = new URL(window.location);
  url.searchParams.set('skinType', skinType);
  window.location.href = url.toString();
}

// ===== TOGGLE FAVORITE =====
function toggleFavorite(recipeId) {
  const btn = event.currentTarget;
  const icon = btn.querySelector('i');
  
  // Toggle icon
  if (icon.classList.contains('far')) {
    icon.classList.remove('far');
    icon.classList.add('fas');
    btn.style.color = 'var(--accent)';
  } else {
    icon.classList.remove('fas');
    icon.classList.add('far');
    btn.style.color = '';
  }

  // Make API call
  fetch(`/api/recipes/${recipeId}/favorite`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
    }
  })
  .then(response => response.json())
  .then(data => {
    console.log('Favorite toggled:', data);
  })
  .catch(error => console.error('Error:', error));
}

// ===== QUICK PREVIEW =====
function quickPreview(recipeId) {
  const modal = new bootstrap.Modal(document.getElementById('quickPreviewModal'));
  modal.show();

  fetch(`/api/recipes/${recipeId}/preview`)
    .then(response => response.json())
    .then(data => {
      document.getElementById('previewContent').innerHTML = `
        <div class="row g-4">
          <div class="col-md-5">
            <img src="${data.image_url || 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600'}" 
                 class="img-fluid rounded-3" 
                 alt="${data.title}">
          </div>
          <div class="col-md-7">
            <h3 class="mb-3">${data.title}</h3>
            <p class="text-muted mb-3">${data.description}</p>
            <div class="d-flex gap-2 mb-3">
              <span class="badge bg-primary">${data.skin_type || 'All Types'}</span>
              <span class="badge bg-secondary">${data.difficulty_level || 'Medium'}</span>
              <span class="badge bg-warning text-dark">
                <i class="fas fa-clock"></i> ${data.preparation_time || '30'} min
              </span>
            </div>
            <div class="mb-3">
              <h6 class="fw-bold">Key Ingredients:</h6>
              <p class="small text-muted">${data.key_ingredients || 'Natural ingredients'}</p>
            </div>
            <a href="/recipes/${recipeId}" class="btn btn-primary w-100">
              View Full Recipe <i class="fas fa-arrow-right ms-2"></i>
            </a>
          </div>
        </div>
      `;
    })
    .catch(error => {
      document.getElementById('previewContent').innerHTML = 
        '<div class="alert alert-danger">Failed to load preview</div>';
    });
}

// ===== SMOOTH SCROLL =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// ===== ANIMATION ON SCROLL =====
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, observerOptions);

document.querySelectorAll('.recipe-card').forEach(card => {
  card.style.opacity = '0';
  card.style.transform = 'translateY(20px)';
  card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  observer.observe(card);
});
</script>
@endsection