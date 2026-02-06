@extends('layouts.app')

@section('title', 'Lien périmé')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto; text-align: center;">
    <h2 style="margin-bottom: 2rem;">Lien périmé</h2>
    
    <p style="margin-bottom: 2rem;">Ce lien court avec le code <strong>{{ $shortUrl->code }}</strong> n'est plus valable.</p>

    <a href="{{ route('shorturls.index') }}">
        <button type="button" class="btn">Retour à la liste</button>
    </a>
</div>
@endsection
