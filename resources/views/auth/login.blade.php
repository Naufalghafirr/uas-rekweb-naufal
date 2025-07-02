<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Materially Admin</title>
    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <!-- DataTables Bootstrap CSS -->
    <link href="{{ asset('assets/css/datatables.bootstrap.min.css') }}" rel="stylesheet">
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
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="min-width:350px; max-width:400px; width:100%;">
        <h3 class="mb-4 text-center">Login Admin</h3>
        <form method="POST" action="{{ route('loginUser') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <p>
                user: admin@gmail.com <br>
                password: admin123
            </p>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>
    
</body>
</html>
