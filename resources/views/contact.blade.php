@extends('layout')

@section('title', 'Contact Us | Natural Skincare Community')

@section('content')
<div class="contact-page">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-primary mb-3">
                        <i class="fas fa-envelope me-3"></i>
                        Contact Us
                    </h1>
                    <p class="lead text-muted">
                        Have questions about our natural skincare recipes? We'd love to hear from you!
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Contact Info -->
                    <div class="col-lg-4">
                        <div class="contact-info">
                            <div class="info-item">
                                <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                <h5>Email Us</h5>
                                <p>info@skincare-recipes.com</p>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-clock fa-2x text-success mb-3"></i>
                                <h5>Response Time</h5>
                                <p>Within 24 hours</p>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-users fa-2x text-info mb-3"></i>
                                <h5>Community</h5>
                                <p>Join 10,000+ skincare enthusiasts</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-lg-8">
                        <div class="contact-form bg-white p-4 rounded-3 shadow">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('contact.send') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-label">Subject *</label>
                                        <input type="text" class="form-control" id="subject" name="subject" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message *</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 80vh;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.info-item {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.info-item:hover {
    transform: translateY(-5px);
}

.info-item h5 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.info-item p {
    color: #6c757d;
    margin: 0;
}

.contact-form .form-label {
    font-weight: 600;
    color: #2c3e50;
}

.contact-form .form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem;
    transition: border-color 0.3s ease;
}

.contact-form .form-control:focus {
    border-color: #4a7c59;
    box-shadow: 0 0 0 3px rgba(74, 124, 89, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #4a7c59, #6b9d7a);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: transform 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #3a6547, #4a7c59);
}

@media (max-width: 768px) {
    .contact-info {
        gap: 1rem;
    }

    .info-item {
        padding: 1.5rem;
    }
}
</style>
@endsection