@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Réinitialiser le mot de passe</h2>
    
    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
        </div>

        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn" style="width: 100%;">
            Réinitialiser le mot de passe
        </button>
    </form>

    <div style="text-align: center; margin-top: 1rem;">
        <a href="{{ route('login') }}">Retour à la connexion</a>
    </div>
</div>
@endsection
