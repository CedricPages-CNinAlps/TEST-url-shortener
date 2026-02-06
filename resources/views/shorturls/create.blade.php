@extends('layouts.app')

@section('title', 'Création d\'un lien raccourci')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="margin: 0;">Création d'un lien raccourci</h2>
        <a href="{{ route('shorturls.index') }}">
            <button type="button" class="btn">Retour à la liste</button>
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shorturls.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="original_url">URL à raccourcir</label>
            <input type="url" id="original_url" name="original_url" value="{{ old('original_url') }}" required 
                   placeholder="https://exemple.com">
        </div>
        <button type="submit" class="btn" style="width: 100%;">Raccourcir</button>
    </form>
</div>
@endsection
