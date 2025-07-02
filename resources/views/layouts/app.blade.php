<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'E-Product' }}</title>
    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ secure_asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="{{ secure_asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <!-- DataTables Bootstrap CSS -->
    <link href="{{ secure_asset('assets/css/datatables.bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons (optional, for sidebar icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #f4f7fa;
        }
        .sidebar {
            min-height: 100vh;
            background: #212121;
            color: #fff;
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
        }
        .sidebar .sidebar-header {
            padding: 2rem 1.5rem 1rem 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            background: #1a1a1a;
            text-align: center;
        }
        .sidebar .nav {
            flex-direction: column;
        }
        .sidebar .nav-link {
            color: #bdbdbd;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 30px 0 0 30px;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #fff;
            color: #1976d2;
        }
        .sidebar .nav-link i {
            margin-right: 1rem;
            font-size: 1.2rem;
        }
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
            background: #f4f7fa;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 0.75rem 2rem;
            position: sticky;
            top: 0;
            z-index: 101;
        }
        .navbar .navbar-brand {
            font-weight: 500;
            color: #1976d2;
        }
        .navbar .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #1976d2;
        }
        .content {
            padding: 2rem 2rem 2rem 2rem;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: none;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                width: 60px;
            }
            .sidebar .sidebar-header, .sidebar .nav-link span {
                display: none;
            }
            .main-content {
                margin-left: 60px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <div class="sidebar-header">
            <i class="bi bi-stack"></i> <span>E-Product</span>
        </div>
        <nav class="flex-grow-1">
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        <i class="bi bi-house-door"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-box"></i> <span>Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-people"></i> <span>Pengguna</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-gear"></i> <span>Pengaturan</span>
                    </a>
                </li> --}}
            </ul>
        </nav>
    </div>
    <div class="main-content">
        <nav class="navbar navbar-expand navbar-light mb-4">
            <div class="container-fluid">
                <span class="navbar-brand">Dashboard</span>
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @endguest
                    @auth
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="#">
                            <i class="bi bi-bell" style="font-size: 1.3rem;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.7rem;">3</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Avatar" class="avatar me-2">
                            <span class="d-none d-md-inline">Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ secure_asset('assets/js/jquery.js') }}"></script>
    <!-- DataTables JS -->
    <script src="{{ secure_asset('assets/js/jquery.datatables.js') }}"></script>
    <script src="{{ secure_asset('assets/js/jquery.datatables.bootstrap5.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ secure_asset('assets/js/toastr.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>