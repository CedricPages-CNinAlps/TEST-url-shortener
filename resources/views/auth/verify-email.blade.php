@extends('layouts.app')

@section('title', 'Vérifier l\'email')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Vérifier votre email</h2>
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <p>Avant de continuer, pourriez-vous vérifier votre email en cliquant sur le lien que nous venons de vous envoyer ?</p>
        <p>Si vous n'avez pas reçu l'email, nous vous en enverrons un autre.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn" style="width: 100%;">
            Renvoyer l'email de vérification
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
        @csrf
        <button type="submit" class="btn-logout" style="width: 100%;">
            Se déconnecter
        </button>
    </form>
</div>
@endsection
