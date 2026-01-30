<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Création d\'un lien raccourcis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('shorturls.index') }}">
                <button type="button" class="btn btn-info" style="margin: 2rem">Retour à la liste</button>
            </a>

            @if($errors->any())
                <div style="color: darkred;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('shorturls.store') }}" method="POST">
                @csrf
                <div>
                    <label for="original_url">URL à raccourcir</label>
                    <input type="text" id="original_url" name="original_url" value="{{ old('original_url') }}" style="width: 100%" required>
                </div>
                <button type="submit" class="btn btn-success" style="margin: 2rem">Raccourcir</button>
            </form>

        </div>
    </div>
</x-app-layout>
