<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Skincare Recipes')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #4a7c59 0%, #6b9d7a 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="/">
                <i class="fas fa-leaf me-2 text-warning"></i>
                Glow Discovery
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill {{ request()->routeIs('home') ? 'active bg-white text-dark' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill {{ request()->routeIs('recipes.browse') ? 'active bg-white text-dark' : '' }}" href="{{ route('recipes.browse') }}">
                            <i class="fas fa-heart me-1"></i>Skin Faves
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill {{ request()->routeIs('gallery.before-after') ? 'active bg-white text-dark' : '' }}" href="{{ route('gallery.before-after') }}">
                            <i class="fas fa-images me-1"></i>Gallery
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 mx-1 rounded-pill {{ request()->routeIs('contact') ? 'active bg-white text-dark' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-3 py-2 rounded-pill bg-light text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <style>
    .navbar-brand {
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover {
        transform: scale(1.05);
    }

    .nav-link {
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }

    .nav-link.active {
        font-weight: 600;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border-radius: 10px;
    }

    .dropdown-item {
        padding: 0.75rem 1.5rem;
        transition: background-color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    /* Mobile responsiveness */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            margin-top: 1rem;
            padding: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .navbar-nav {
            text-align: center;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            justify-content: center;
            margin: 0.25rem 0;
        }

        .navbar-brand {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .navbar-brand {
            font-size: 1.1rem;
        }

        .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
    </style>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @yield('scripts')
</body>
</html>