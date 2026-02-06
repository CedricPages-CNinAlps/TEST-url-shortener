<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f3f4f6;
        }
        .navbar {
            background-color: #1f2937;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .welcome {
            text-align: center;
            margin-bottom: 3rem;
        }
        .welcome h2 {
            color: #1f2937;
            margin-bottom: 1rem;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #3b82f6;
        }
        .stat-label {
            color: #6b7280;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>URL Shortener</h1>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}">Tableau de bord</a>
            <a href="{{ route('shorturls.index') }}">Mes URLs</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Déconnexion</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="welcome">
            <h2>Bienvenue, {{ Auth::user()->name }} !</h2>
            <p>Gérez vos URLs raccourcies depuis ce tableau de bord.</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ App\Models\ShortUrl::where('user_id', Auth::id())->count() }}</div>
                <div class="stat-label">URLs créées</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ App\Models\ShortUrl::where('user_id', Auth::id())->sum('clicks') }}</div>
                <div class="stat-label">Clics totaux</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ App\Models\ShortUrl::where('user_id', Auth::id())->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                <div class="stat-label">Cette semaine</div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Actions rapides</h3>
            <p><a href="{{ route('shorturls.index') }}" style="color: #3b82f6;">Voir toutes mes URLs</a></p>
            <p><a href="{{ route('shorturls.create') }}" style="color: #3b82f6;">Créer une nouvelle URL</a></p>
        </div>
    </div>
</body>
</html>
