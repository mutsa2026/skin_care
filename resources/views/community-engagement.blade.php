@extends('layout')

@section('title', $recipe->title . ' | Natural Skincare Community')

@section('content')
<div class="recipe-details">
    <!-- Hero Section -->
    <div class="recipe-hero">
        <div class="hero-image">
            <img src="{{ $recipe->image_url ?? 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=1200' }}" 
                 alt="{{ $recipe->title }}" class="hero-img">
            <div class="hero-overlay">
                <div class="hero-content">
                    <h1 class="recipe-title">{{ $recipe->title }}</h1>
                    <p class="recipe-description">{{ $recipe->description }}</p>
                    <div class="recipe-meta">
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            {{ $recipe->preparation_time }} min
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-signal"></i>
                            {{ ucfirst($recipe->difficulty_level) }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-user"></i>
                            {{ $recipe->skinType->name ?? 'All Skin Types' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="recipe-content">
            <div class="row">
                <!-- Left Column - Recipe Details -->
                <div class="col-lg-8">
                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <button class="action-btn btn-primary" onclick="shareRecipe()">
                            <i class="fas fa-share-alt"></i>
                            Share Recipe
                        </button>
                        <button class="action-btn btn-secondary" onclick="saveRecipe()">
                            <i class="far fa-bookmark"></i>
                            Save Recipe
                        </button>
                        <button class="action-btn btn-outline">
                            <i class="far fa-heart"></i>
                            Like
                        </button>
                    </div>

                    <!-- Ingredients Section -->
                    <section class="recipe-section">
                        <h2 class="section-title">
                            <i class="fas fa-list-check"></i>
                            Ingredients
                        </h2>
                        <div class="ingredients-grid">
                            @foreach($recipe->ingredients as $ingredient)
                            <div class="ingredient-item">
                                <div class="ingredient-info">
                                    <span class="ingredient-name">{{ $ingredient->name }}</span>
                                    <span class="ingredient-quantity">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->measurement_unit }}</span>
                                </div>
                                <div class="ingredient-actions">
                                    <button class="btn-icon" title="Add to shopping list">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- Instructions Section -->
                    <section class="recipe-section">
                        <h2 class="section-title">
                            <i class="fas fa-list-ol"></i>
                            Instructions
                        </h2>
                        <div class="instructions-list">
                            @php
                                $steps = explode("\n", $recipe->instructions);
                            @endphp
                            @foreach($steps as $index => $step)
                                @if(trim($step))
                                <div class="instruction-step">
                                    <div class="step-number">{{ $index + 1 }}</div>
                                    <div class="step-content">
                                        <p>{{ trim($step) }}</p>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </section>

                    <!-- Tags & Categories -->
                    <section class="recipe-section">
                        <h2 class="section-title">
                            <i class="fas fa-tags"></i>
                            Tags & Categories
                        </h2>
                        <div class="tags-container">
                            <span class="tag skin-type">{{ $recipe->skinType->name ?? 'General' }}</span>
                            <span class="tag difficulty">{{ ucfirst($recipe->difficulty_level) }}</span>
                            @if($recipe->vegan ?? false)
                                <span class="tag vegan">Vegan</span>
                            @endif
                            @if($recipe->organic ?? false)
                                <span class="tag organic">Organic</span>
                            @endif
                            @if($recipe->featured ?? false)
                                <span class="tag featured">Featured</span>
                            @endif
                        </div>
                    </section>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="col-lg-4">
                    <!-- Recipe Stats -->
                    <div class="sidebar-card stats-card">
                        <h3 class="card-title">Recipe Stats</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-value">247</div>
                                <div class="stat-label">Views</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">89</div>
                                <div class="stat-label">Likes</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">34</div>
                                <div class="stat-label">Comments</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">156</div>
                                <div class="stat-label">Saves</div>
                            </div>
                        </div>
                    </div>

                    <!-- Author Info -->
                    <div class="sidebar-card author-card">
                        <h3 class="card-title">Created By</h3>
                        <div class="author-info">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->author_name ?? 'Anonymous') }}&background=random&size=100"
                                 alt="Author" class="author-avatar">
                            <div class="author-details">
                                <h4 class="author-name">{{ $recipe->author_name ?? 'Anonymous' }}</h4>
                                <p class="author-bio">Skincare Enthusiast</p>
                                <button class="btn-outline btn-sm">View Profile</button>
                            </div>
                        </div>
                    </div>

                    <!-- Nutrition Info -->
                    <div class="sidebar-card nutrition-card">
                        <h3 class="card-title">Quick Tips</h3>
                        <div class="tips-list">
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Patch test before full application</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Store in airtight container</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Use within 2 weeks</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Keep refrigerated</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <section class="comments-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-comments"></i>
                    Community Comments
                </h2>
                <span class="comments-count">34 comments</span>
            </div>

            <!-- Add Comment -->
            <div class="add-comment">
                <div class="comment-form">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" 
                         alt="User" class="user-avatar">
                    <div class="form-content">
                        <textarea placeholder="Share your experience with this recipe..." 
                                  class="comment-input"></textarea>
                        <div class="form-actions">
                            <div class="action-buttons">
                                <button class="btn-icon" title="Add image">
                                    <i class="far fa-image"></i>
                                </button>
                                <button class="btn-icon" title="Add emoji">
                                    <i class="far fa-smile"></i>
                                </button>
                            </div>
                            <button class="btn-primary btn-sm">Post Comment</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments List -->
            <div class="comments-list">
                <!-- Sample Comment -->
                <div class="comment">
                    <img src="https://ui-avatars.com/api/?name=Sarah&background=random" 
                         alt="Sarah" class="user-avatar">
                    <div class="comment-content">
                        <div class="comment-header">
                            <h4 class="user-name">Sarah Johnson</h4>
                            <span class="comment-time">2 hours ago</span>
                        </div>
                        <p class="comment-text">
                            This recipe worked amazingly for my dry skin! I added a bit more honey 
                            and it was perfect. My skin feels so hydrated and glowing! ✨
                        </p>
                        <div class="comment-actions">
                            <button class="btn-action">
                                <i class="far fa-thumbs-up"></i>
                                <span>12</span>
                            </button>
                            <button class="btn-action">
                                <i class="fas fa-reply"></i>
                                Reply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Another Sample Comment -->
                <div class="comment">
                    <img src="https://ui-avatars.com/api/?name=Mike&background=random" 
                         alt="Mike" class="user-avatar">
                    <div class="comment-content">
                        <div class="comment-header">
                            <h4 class="user-name">Mike Thompson</h4>
                            <span class="comment-time">1 day ago</span>
                        </div>
                        <p class="comment-text">
                            Great recipe! I have sensitive skin and this worked perfectly without 
                            any irritation. The honey makes it so soothing. 🍯
                        </p>
                        <div class="comment-actions">
                            <button class="btn-action">
                                <i class="far fa-thumbs-up"></i>
                                <span>8</span>
                            </button>
                            <button class="btn-action">
                                <i class="fas fa-reply"></i>
                                Reply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<style>
/* Enhanced Recipe Details Styles */
:root {
    --primary-color: #4a7c59;
    --primary-light: #6b9d7a;
    --primary-dark: #3a6547;
    --secondary-color: #f8a488;
    --accent-color: #8b5fbf;
    --text-dark: #2c3e50;
    --text-light: #6c757d;
    --bg-light: #f8f9fa;
    --border-color: #e9ecef;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.15);
    --transition: all 0.3s ease;
}

.recipe-details {
    background: var(--bg-light);
}

/* Hero Section */
.recipe-hero {
    position: relative;
    margin-bottom: 2rem;
}

.hero-image {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(74, 124, 89, 0.9) 0%, rgba(139, 95, 191, 0.7) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.hero-content {
    text-align: center;
    max-width: 800px;
    padding: 2rem;
}

.recipe-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.recipe-description {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.recipe-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.btn-secondary {
    background: var(--secondary-color);
    color: white;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--border-color);
    color: var(--text-dark);
}

.btn-outline:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

/* Recipe Sections */
.recipe-section {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.section-title {
    color: var(--text-dark);
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title i {
    color: var(--primary-color);
}

/* Ingredients */
.ingredients-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.ingredient-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 10px;
    transition: var(--transition);
}

.ingredient-item:hover {
    transform: translateX(5px);
    background: #fff;
    box-shadow: var(--shadow);
}

.ingredient-info {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ingredient-name {
    font-weight: 500;
    color: var(--text-dark);
}

.ingredient-quantity {
    color: var(--primary-color);
    font-weight: 600;
}

.ingredient-actions .btn-icon {
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 5px;
    transition: var(--transition);
}

.ingredient-actions .btn-icon:hover {
    background: var(--primary-color);
    color: white;
}

/* Instructions */
.instructions-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.instruction-step {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.step-number {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    flex-shrink: 0;
}

.step-content {
    flex: 1;
    padding-top: 0.5rem;
}

.step-content p {
    margin: 0;
    line-height: 1.6;
    color: var(--text-dark);
}

/* Tags */
.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.tag {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: capitalize;
}

.tag.skin-type {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.tag.difficulty {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

.tag.vegan {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
}

.tag.organic {
    background: linear-gradient(135deg, #43e97b, #38f9d7);
    color: white;
}

.tag.featured {
    background: linear-gradient(135deg, #ffecd2, #fcb69f);
    color: var(--text-dark);
}

/* Sidebar Cards */
.sidebar-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.card-title {
    color: var(--text-dark);
    font-size: 1.25rem;
    margin-bottom: 1rem;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 0.5rem;
}

/* Stats */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 10px;
    transition: var(--transition);
}

.stat-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Author Card */
.author-info {
    text-align: center;
}

.author-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    border: 3px solid var(--primary-color);
}

.author-name {
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.author-bio {
    color: var(--text-light);
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

/* Tips */
.tips-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tip-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--bg-light);
    border-radius: 8px;
    transition: var(--transition);
}

.tip-item:hover {
    background: #fff;
    box-shadow: var(--shadow);
}

.tip-item i {
    color: var(--primary-color);
    flex-shrink: 0;
}

/* Comments Section */
.comments-section {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 1rem;
}

.comments-count {
    color: var(--text-light);
    font-weight: 500;
}

/* Comment Form */
.add-comment {
    margin-bottom: 2rem;
}

.comment-form {
    display: flex;
    gap: 1rem;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    flex-shrink: 0;
}

.form-content {
    flex: 1;
}

.comment-input {
    width: 100%;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 1rem;
    resize: vertical;
    min-height: 80px;
    transition: var(--transition);
}

.comment-input:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(74, 124, 89, 0.1);
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.75rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 5px;
    transition: var(--transition);
}

.btn-icon:hover {
    background: var(--bg-light);
    color: var(--primary-color);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Comments List */
.comments-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.comment {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 10px;
    transition: var(--transition);
}

.comment:hover {
    background: #fff;
    box-shadow: var(--shadow);
}

.comment-content {
    flex: 1;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.user-name {
    color: var(--text-dark);
    margin: 0;
    font-size: 1rem;
}

.comment-time {
    color: var(--text-light);
    font-size: 0.875rem;
}

.comment-text {
    color: var(--text-dark);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.comment-actions {
    display: flex;
    gap: 1rem;
}

.btn-action {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 5px;
    transition: var(--transition);
    font-size: 0.875rem;
}

.btn-action:hover {
    background: rgba(74, 124, 89, 0.1);
    color: var(--primary-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .recipe-title {
        font-size: 2rem;
    }
    
    .recipe-meta {
        gap: 1rem;
    }
    
    .meta-item {
        font-size: 0.875rem;
    }
    
    .quick-actions {
        justify-content: center;
    }
    
    .action-btn {
        flex: 1;
        min-width: 120px;
        justify-content: center;
    }
    
    .ingredient-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .comment-form {
        flex-direction: column;
    }
    
    .user-avatar {
        align-self: flex-start;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .recipe-hero {
        margin-bottom: 1rem;
    }
    
    .hero-image {
        height: 300px;
    }
    
    .recipe-section {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .instruction-step {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .step-number {
        align-self: center;
    }
}
</style>

<script>
function shareRecipe() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $recipe->title }}',
            text: '{{ $recipe->description }}',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href)
            .then(() => {
                alert('Recipe link copied to clipboard!');
            })
            .catch(err => {
                console.error('Failed to copy: ', err);
            });
    }
}

function saveRecipe() {
    // Simulate saving recipe
    const saveBtn = document.querySelector('.action-btn.btn-secondary');
    const icon = saveBtn.querySelector('i');
    
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        saveBtn.innerHTML = '<i class="fas fa-bookmark"></i> Saved';
        alert('Recipe saved to your collection!');
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        saveBtn.innerHTML = '<i class="far fa-bookmark"></i> Save Recipe';
        alert('Recipe removed from your collection!');
    }
}

// Add interactivity to like button
document.addEventListener('DOMContentLoaded', function() {
    const likeBtn = document.querySelector('.action-btn.btn-outline');
    
    likeBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            this.innerHTML = '<i class="fas fa-heart"></i> Liked';
            this.style.color = '#dc3545';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            this.innerHTML = '<i class="far fa-heart"></i> Like';
            this.style.color = '';
        }
    });
    
    // Add shopping list functionality
    const addToCartButtons = document.querySelectorAll('.ingredient-actions .btn-icon');
    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const ingredientName = this.closest('.ingredient-item').querySelector('.ingredient-name').textContent;
            alert(`Added "${ingredientName}" to your shopping list!`);
        });
    });
});
</script>
@endsection