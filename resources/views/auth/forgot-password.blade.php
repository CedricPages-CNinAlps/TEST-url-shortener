@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Mot de passe oublié</h2>
    
    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>

        <button type="submit" class="btn" style="width: 100%;">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <div style="text-align: center; margin-top: 1rem;">
        <a href="{{ route('login') }}">Retour à la connexion</a>
    </div>
</div>
@endsection
