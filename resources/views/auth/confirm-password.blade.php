@extends('layouts.app')

@section('title', 'Confirmer le mot de passe')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Confirmer votre mot de passe</h2>
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <p>Pour votre sécurité, veuillez confirmer votre mot de passe pour continuer.</p>
    </div>

    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn" style="width: 100%;">
            Confirmer
        </button>
    </form>
</div>
@endsection
