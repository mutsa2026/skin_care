@extends('layout')

@section('title', 'Before & After Gallery | Natural Skincare Community')

@section('content')
<div class="gallery-page">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">
                <i class="fas fa-images me-3"></i>
                Before & After Gallery
            </h1>
            <p class="lead text-muted">
                See real results from our community members using natural skincare recipes
            </p>
        </div>

        <!-- Gallery Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-3 shadow">
                    <i class="fas fa-camera fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold text-primary">150+</h3>
                    <p class="text-muted mb-0">Transformations</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-3 shadow">
                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold text-success">89</h3>
                    <p class="text-muted mb-0">Community Members</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-3 shadow">
                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                    <h3 class="fw-bold text-warning">4.8</h3>
                    <p class="text-muted mb-0">Average Rating</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-3 shadow">
                    <i class="fas fa-heart fa-3x text-danger mb-3"></i>
                    <h3 class="fw-bold text-danger">95%</h3>
                    <p class="text-muted mb-0">Satisfaction Rate</p>
                </div>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex justify-content-center mb-4 flex-wrap gap-2">
            <button class="btn btn-primary active" onclick="filterGallery('all')">All Results</button>
            <button class="btn btn-outline-primary" onclick="filterGallery('acne')">Acne Treatment</button>
            <button class="btn btn-outline-primary" onclick="filterGallery('anti-aging')">Anti-Aging</button>
            <button class="btn btn-outline-primary" onclick="filterGallery('brightening')">Brightening</button>
            <button class="btn btn-outline-primary" onclick="filterGallery('hydration')">Hydration</button>
        </div>

        <!-- Gallery Grid -->
        <div class="row g-4" id="gallery-grid">
            <!-- Sample Gallery Items -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="acne">
                <div class="gallery-card card border-0 shadow-sm">
                    <div class="position-relative">
                        <div class="before-after-container">
                            <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=400"
                                 alt="Before" class="gallery-img before-img">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400"
                                 alt="After" class="gallery-img after-img">
                        </div>
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success">4 weeks</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="badge bg-primary">Acne Treatment</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tea Tree Oil Treatment</h5>
                        <p class="card-text text-muted small">
                            "This natural treatment cleared my acne in just 4 weeks! My skin feels amazing."
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">By Sarah M.</small>
                            <div class="rating">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 gallery-item" data-category="anti-aging">
                <div class="gallery-card card border-0 shadow-sm">
                    <div class="position-relative">
                        <div class="before-after-container">
                            <img src="https://images.unsplash.com/photo-1594824804732-ca8db723f8fa?w=400"
                                 alt="Before" class="gallery-img before-img">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400"
                                 alt="After" class="gallery-img after-img">
                        </div>
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success">6 weeks</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="badge bg-primary">Anti-Aging</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Aloe Vera & Honey Mask</h5>
                        <p class="card-text text-muted small">
                            "My fine lines are less noticeable and my skin looks more youthful!"
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">By Emma L.</small>
                            <div class="rating">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 gallery-item" data-category="brightening">
                <div class="gallery-card card border-0 shadow-sm">
                    <div class="position-relative">
                        <div class="before-after-container">
                            <img src="https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?w=400"
                                 alt="Before" class="gallery-img before-img">
                            <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400"
                                 alt="After" class="gallery-img after-img">
                        </div>
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success">3 weeks</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="badge bg-primary">Brightening</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Lemon & Honey Scrub</h5>
                        <p class="card-text text-muted small">
                            "My skin tone is so much more even now. This scrub works wonders!"
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">By Maya K.</small>
                            <div class="rating">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add more gallery items as needed -->
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5">
            <div class="cta-section bg-primary text-white p-5 rounded-3">
                <h2 class="mb-3">Share Your Transformation!</h2>
                <p class="mb-4">Upload your before and after photos to inspire others in our community</p>
                <button class="btn btn-light btn-lg px-4">
                    <i class="fas fa-upload me-2"></i>Upload Your Results
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 80vh;
}

.gallery-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
}

.before-after-container {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.3s ease;
}

.before-img {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 1;
}

.after-img {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.before-after-container:hover .before-img {
    opacity: 0;
}

.before-after-container:hover .after-img {
    opacity: 1;
}

.stat-card {
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.rating {
    display: flex;
    gap: 2px;
}

.btn {
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #4a7c59, #6b9d7a);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #3a6547, #4a7c59);
    transform: translateY(-2px);
}

.cta-section {
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .before-after-container {
        height: 250px;
    }

    .gallery-card .card-body {
        padding: 1rem;
    }
}
</style>

<script>
function filterGallery(category) {
    const items = document.querySelectorAll('.gallery-item');
    const buttons = document.querySelectorAll('.btn');

    // Update button states
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    // Filter items
    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Initialize with all items visible
document.addEventListener('DOMContentLoaded', function() {
    filterGallery('all');
});
</script>
@endsection