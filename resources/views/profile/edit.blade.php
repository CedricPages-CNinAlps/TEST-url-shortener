@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="card">
    <h2>Informations du profil</h2>
    <p>Mettez à jour les informations de votre profil et votre adresse e-mail.</p>
    
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        
        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            
            @if ($user->email_verified_at)
                <p style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                    Votre adresse e-mail est vérifiée.
                </p>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button type="submit" class="btn">Enregistrer</button>

            @if (session('status'))
                <div style="font-size: 0.875rem; color: #6b7280;">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </form>
</div>

<div class="card">
    <h2>Supprimer le compte</h2>
    <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.</p>
    
    <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
        @csrf
        @method('DELETE')

        @if ($errors->userDeletion->any())
            <div class="errors">
                @foreach ($errors->userDeletion->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1rem;">
            <div class="form-group" style="margin: 0; flex: 1;">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="current-password" style="width: 200px;">
            </div>
            <button type="submit" class="btn-logout">Supprimer le compte</button>
        </div>
    </form>
</div>
@endsection
