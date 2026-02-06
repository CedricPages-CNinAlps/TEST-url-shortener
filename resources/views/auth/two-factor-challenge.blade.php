@extends('layouts.app')

@section('title', 'Authentification à deux facteurs')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Authentification à deux facteurs</h2>
    
    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="code">Code d'authentification</label>
            <input type="text" id="code" name="code" required autocomplete="one-time-code" autofocus>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="recovery" value="1">
                Utiliser un code de récupération
            </label>
        </div>

        <button type="submit" class="btn" style="width: 100%;">
            Se connecter
        </button>
    </form>

    <div style="text-align: center; margin-top: 1rem;">
        <a href="{{ route('login') }}">Retour à la connexion</a>
    </div>
</div>
@endsection
