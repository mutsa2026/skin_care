@extends('layout')

@section('title', 'Skincare Recipes - Natural Beauty Community')

@section('content')
<div class="container-fluid py-5">
    {{-- HERO SECTION --}}
    <section class="hero-section text-center mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-start">
                    <h1 class="display-4 fw-bold text-primary mb-4">
                        <i class="fas fa-leaf me-3"></i>
                        Natural Skincare Recipes
                    </h1>
                    <p class="lead text-muted mb-4">
                        Discover {{ \App\Models\Recipe::count() }} natural skincare recipes crafted by our community.
                        From face masks to serums, find the perfect treatment for your skin type.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#recipes" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-search me-2"></i>Browse Recipes
                        </a>
                        <a href="#create" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-plus me-2"></i>Create Recipe
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         class="img-fluid rounded-3 shadow-lg" alt="Natural skincare ingredients">
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY STATS --}}
    <section class="stats-section mb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h3 class="fw-bold text-primary" id="totalMembers">{{ \App\Models\User::count() }}</h3>
                            <p class="text-muted mb-0">Community Members</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-book-open fa-3x text-success mb-3"></i>
                            <h3 class="fw-bold text-success" id="totalRecipes">{{ \App\Models\Recipe::count() }}</h3>
                            <p class="text-muted mb-0">Recipes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-leaf fa-3x text-info mb-3"></i>
                            <h3 class="fw-bold text-info" id="totalIngredients">{{ \App\Models\Ingredient::count() }}</h3>
                            <p class="text-muted mb-0">Ingredients</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-tags fa-3x text-warning mb-3"></i>
                            <h3 class="fw-bold text-warning" id="totalSkinTypes">{{ \App\Models\SkinType::count() }}</h3>
                            <p class="text-muted mb-0">Skin Types</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURED RECIPES --}}
    <section class="featured-recipes mb-5" id="recipes">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary mb-3">
                    <i class="fas fa-star me-2"></i>Featured Recipes
                </h2>
                <p class="text-muted">Handpicked recipes loved by our community</p>
            </div>

            <div class="row g-4">
                {{-- Featured Recipe 1 --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm recipe-card">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600"
                                 class="card-img-top recipe-image" alt="Soothing Aloe Vera Mask" style="height: 250px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-danger">Featured</span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge bg-dark bg-opacity-75">5 min</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Soothing Aloe Vera Mask</h5>
                            <p class="card-text text-muted small">A calming mask perfect for irritated or sunburned skin</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star text-warning small"></i>
                                    @endfor
                                    <small class="text-muted">(0)</small>
                                </div>
                                <span class="badge bg-success">Easy</span>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-primary">Sensitive Skin</span>
                                <span class="badge bg-success">Vegan</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('recipes.show', 1) }}" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-eye me-2"></i>View Recipe
                                </a>
                                <button class="btn btn-outline-success" onclick="toggleFavorite(1)">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Featured Recipe 2 --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm recipe-card">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600"
                                 class="card-img-top recipe-image" alt="Brightening Lemon Honey Scrub" style="height: 250px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge bg-dark bg-opacity-75">3 min</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Brightening Lemon Honey Scrub</h5>
                            <p class="card-text text-muted small">Natural exfoliation and brightening for dull skin</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star text-warning small"></i>
                                    @endfor
                                    <small class="text-muted">(0)</small>
                                </div>
                                <span class="badge bg-success">Easy</span>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-primary">Normal Skin</span>
                                <span class="badge bg-success">Vegan</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('recipes.show', 3) }}" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-eye me-2"></i>View Recipe
                                </a>
                                <button class="btn btn-outline-success" onclick="toggleFavorite(3)">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Featured Recipe 3 --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm recipe-card">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600"
                                 class="card-img-top recipe-image" alt="Anti-Inflammatory Turmeric Mask" style="height: 250px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge bg-dark bg-opacity-75">5 min</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Anti-Inflammatory Turmeric Mask</h5>
                            <p class="card-text text-muted small">Reduces inflammation and brightens skin tone</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star text-warning small"></i>
                                    @endfor
                                    <small class="text-muted">(0)</small>
                                </div>
                                <span class="badge bg-success">Easy</span>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-primary">Oily Skin</span>
                                <span class="badge bg-success">Vegan</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('recipes.show', 4) }}" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-eye me-2"></i>View Recipe
                                </a>
                                <button class="btn btn-outline-success" onclick="toggleFavorite(4)">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('recipes.browse') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-th me-2"></i>View All Recipes
                </a>
            </div>
        </div>
    </section>

    {{-- CATEGORIES SECTION --}}
    <section class="categories-section mb-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary mb-3">
                    <i class="fas fa-th-large me-2"></i>Recipe Categories
                </h2>
                <p class="text-muted">Find recipes by category and skin concern</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="category-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-spa fa-3x text-primary mb-3"></i>
                            <h5 class="card-title fw-bold">Face Masks</h5>
                            <p class="card-text text-muted small">Deep cleansing and nourishing masks</p>
                            <a href="{{ route('recipes.browse', ['category' => 'face_mask']) }}" class="btn btn-outline-primary">
                                Browse <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-tint fa-3x text-info mb-3"></i>
                            <h5 class="card-title fw-bold">Serums</h5>
                            <p class="card-text text-muted small">Concentrated treatments for specific concerns</p>
                            <a href="{{ route('recipes.browse', ['category' => 'serum']) }}" class="btn btn-outline-primary">
                                Browse <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-sun fa-3x text-warning mb-3"></i>
                            <h5 class="card-title fw-bold">Moisturizers</h5>
                            <p class="card-text text-muted small">Hydrating creams and lotions</p>
                            <a href="{{ route('recipes.browse', ['category' => 'moisturizer']) }}" class="btn btn-outline-primary">
                                Browse <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-shower fa-3x text-success mb-3"></i>
                            <h5 class="card-title fw-bold">Cleansers</h5>
                            <p class="card-text text-muted small">Gentle cleansing recipes</p>
                            <a href="{{ route('recipes.browse', ['category' => 'cleanser']) }}" class="btn btn-outline-primary">
                                Browse <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SKIN TYPES SECTION --}}
    <section class="skin-types-section mb-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary mb-3">
                    <i class="fas fa-user-friends me-2"></i>Recipes by Skin Type
                </h2>
                <p class="text-muted">Find the perfect recipes for your skin type</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="skin-type-card card border-0 shadow-sm text-center p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-user fa-2x text-primary mb-2"></i>
                            <h6 class="card-title fw-bold mb-1">Dry Skin</h6>
                            <small class="text-muted">Hydrating recipes</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="skin-type-card card border-0 shadow-sm text-center p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-user fa-2x text-info mb-2"></i>
                            <h6 class="card-title fw-bold mb-1">Oily Skin</h6>
                            <small class="text-muted">Balancing recipes</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="skin-type-card card border-0 shadow-sm text-center p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-user fa-2x text-success mb-2"></i>
                            <h6 class="card-title fw-bold mb-1">Combination</h6>
                            <small class="text-muted">Mixed recipes</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="skin-type-card card border-0 shadow-sm text-center p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-user fa-2x text-warning mb-2"></i>
                            <h6 class="card-title fw-bold mb-1">Sensitive</h6>
                            <small class="text-muted">Gentle recipes</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="skin-type-card card border-0 shadow-sm text-center p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-user fa-2x text-secondary mb-2"></i>
                            <h6 class="card-title fw-bold mb-1">Normal</h6>
                            <small class="text-muted">General recipes</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="skin-type-card card border-0 shadow-sm text-center p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-user fa-2x text-danger mb-2"></i>
                            <h6 class="card-title fw-bold mb-1">Acne-Prone</h6>
                            <small class="text-muted">Clearing recipes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY SECTION --}}
    <section class="community-section mb-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary mb-3">
                    <i class="fas fa-users me-2"></i>Join Our Community
                </h2>
                <p class="text-muted">Share your recipes, get feedback, and learn from others</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="community-feature card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-share-alt fa-3x text-primary mb-3"></i>
                            <h5 class="card-title fw-bold">Share Recipes</h5>
                            <p class="card-text text-muted">Upload your favorite natural skincare recipes and help others discover new treatments.</p>
                            <a href="#create" class="btn btn-primary">Share Recipe</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="community-feature card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-comments fa-3x text-info mb-3"></i>
                            <h5 class="card-title fw-bold">Get Feedback</h5>
                            <p class="card-text text-muted">Receive constructive feedback from our community of skincare enthusiasts.</p>
                            <a href="{{ route('recipes.browse') }}" class="btn btn-info">Browse Recipes</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="community-feature card border-0 shadow-sm text-center p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                            <h5 class="card-title fw-bold">Learn & Discover</h5>
                            <p class="card-text text-muted">Discover new ingredients, techniques, and skincare tips from fellow community members.</p>
                            <a href="#tips" class="btn btn-warning">View Tips</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CALL TO ACTION --}}
    <section class="cta-section bg-primary text-white py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Ready to Start Your Skincare Journey?</h2>
            <p class="lead mb-4">Join thousands of people creating natural beauty at home</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="/recipes/create" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-plus me-2"></i>Create Your First Recipe
                </a>
                <a href="{{ route('recipes.browse') }}" class="btn btn-outline-light btn-lg px-4">
                    <i class="fas fa-search me-2"></i>Browse All Recipes
                </a>
            </div>
        </div>
    </section>
</div>

<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 0 0 50px 50px;
    padding: 5rem 0;
    margin-bottom: 3rem;
}

/* Stats Cards */
.stat-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

/* Recipe Cards */
.recipe-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.recipe-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.recipe-image {
    transition: transform 0.5s ease;
}

.recipe-card:hover .recipe-image {
    transform: scale(1.08);
}

/* Category Cards */
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

/* Skin Type Cards */
.skin-type-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    cursor: pointer;
}

.skin-type-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
}

/* Community Features */
.community-feature {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.community-feature:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

/* CTA Section */
.cta-section {
    border-radius: 50px 50px 0 0;
    margin-top: 3rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0;
        border-radius: 0 0 30px 30px;
    }

    .cta-section {
        border-radius: 30px 30px 0 0;
        margin-top: 2rem;
    }

    .display-4 {
        font-size: 2.5rem;
    }
}
</style>

<script>
// Toggle favorite functionality
function toggleFavorite(recipeId) {
    // Simple feedback for now
    const button = event.target.closest('button');
    const icon = button.querySelector('i');

    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        showNotification('Recipe added to favorites!', 'success');
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        showNotification('Recipe removed from favorites', 'info');
    }
}

// Simple notification system
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close float-end" onclick="this.parentElement.remove()"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 3000);
}

// Animate stats on scroll
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumber(entry.target);
            }
        });
    }, observerOptions);

    // Observe stat numbers
    document.querySelectorAll('#totalMembers, #totalRecipes, #totalComments, #totalReviews').forEach(el => {
        observer.observe(el);
    });
});

function animateNumber(element) {
    const target = parseInt(element.textContent.replace(/[^\d]/g, ''));
    const duration = 2000;
    const start = performance.now();
    const startValue = 0;

    function update(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);

        // Easing function
        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
        const current = Math.floor(startValue + (target - startValue) * easeOutQuart);

        element.textContent = current.toLocaleString() + (element.textContent.match(/[A-Za-z%]/) || '');

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}
</script>
@endsection