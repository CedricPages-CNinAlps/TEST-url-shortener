<x-public-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Lien périmé') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>Ce lien court avec le code <strong>{{ $shortUrl->code }}</strong> n'est plus valable.</p>

            <a href="{{ route('shorturls.index') }}">
                <button type="button" class="btn btn-info" style="margin: 2rem">Retour à la liste</button>
            </a>
        </div>


    </div>
</x-public-layout>
