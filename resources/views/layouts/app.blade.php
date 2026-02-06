<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'URL Shortener')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }
        
        .navbar {
            background-color: #1f2937;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .navbar h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        
        .nav-links a:hover {
            background-color: #374151;
        }
        
        .btn {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }
        
        .btn:hover {
            background-color: #2563eb;
        }
        
        .btn-logout {
            background-color: #ef4444;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        
        .btn-logout:hover {
            background-color: #dc2626;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .errors {
            color: #ef4444;
            margin-bottom: 1rem;
        }
        
        .errors p {
            margin-bottom: 0.5rem;
        }
        
        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.25rem;
            margin: 1rem 0;
            padding: 0;
            list-style: none;
        }
        
        .pagination li {
            list-style: none;
        }
        
        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            margin: 0;
        }
        
        .pagination a:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
            color: #111827;
        }
        
        .pagination .active span {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
        
        .pagination .disabled span {
            background-color: #f9fafb;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }
        
        /* Styles plus spécifiques pour Laravel */
        ul.pagination li a,
        ul.pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem !important;
            height: 2.5rem !important;
            padding: 0 0.75rem !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            background-color: white !important;
            color: #374151 !important;
            text-decoration: none !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            transition: all 0.2s !important;
            margin: 0 !important;
            line-height: 1 !important;
        }
        
        ul.pagination li a:hover {
            background-color: #f9fafb !important;
            border-color: #9ca3af !important;
            color: #111827 !important;
        }
        
        ul.pagination li.active span {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: white !important;
        }
        
        ul.pagination li.disabled span {
            background-color: #f9fafb !important;
            border-color: #e5e7eb !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
        }
        
        .pagination .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>URL Shortener</h1>
        <div class="nav-links">
            @guest
                <a href="{{ route('login') }}">Connexion</a>
                <a href="{{ route('register') }}">Inscription</a>
            @else
                <a href="{{ route('dashboard') }}">Tableau de bord</a>
                <a href="{{ route('shorturls.index') }}">Mes URLs</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Déconnexion</button>
                </form>
            @endguest
        </div>
    </nav>

    <main class="container">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
