<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Mes liens raccourcis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('shorturls.create') }}">
                <button type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium mb-4">Ajouter un lien</button>
            </a>

            <div class="overflow-x-auto">
                <table class="w-full max-w-4xl mx-auto divide-y divide-gray-300 dark:divide-gray-700 table-fixed">
                    <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16">
                        ID
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        URL originale
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        URL courte
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-24">
                        Nb Cliques
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-32">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($shortUrls as $shortUrl)
                    @php
                        $shortUrlFull = url('/r/'.$shortUrl->code);
                    @endphp
                    <tr>
                        <td class="px-4 py-2 text-center text-sm font-medium text-gray-900 space-x-3">{{ $shortUrl->id }}</td>
                        <td class="px-4 py-2 text-center text-sm font-medium text-gray-900 space-x-3">
                            <a href="{{ $shortUrl->original_url }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800 truncate block">{{ $shortUrl->original_url }}</a>
                        </td>
                        <td class="px-4 py-2 text-center text-sm font-medium text-gray-900 space-x-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="short-url-link text-blue-600 hover:text-blue-800 truncate block"
                                   data-url="{{ $shortUrlFull }}" data-id="{{ $shortUrl->id }}">{{ $shortUrlFull }}</a>
                                <button type="button"
                                        class="px-2 py-1 text-xs bg-gray-200 hover:bg-gray-300 rounded text-gray-700 btn-copy"
                                        data-url="{{ $shortUrlFull }}" data-id="{{ $shortUrl->id }}">
                                    Copier
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-center text-sm font-medium text-gray-900">
                            <span class="clicks-count font-semibold"
                                  data-id="{{ $shortUrl->id }}">{{ $shortUrl->clicks }}</span>
                        </td>
                        <td class="px-4 py-2 text-center text-sm font-medium text-gray-900 space-x-3">
                            <a href="{{ route('shorturls.edit', $shortUrl) }}"
                               class="text-blue-600 hover:text-blue-800 mr-2">
                                Éditer
                            </a>
                            <form action="{{ route('shorturls.destroy', $shortUrl) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ce lien ?')"
                                        class="text-red-600 hover:text-red-800">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Aucun lien pour le moment.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>

            <div>{{ $shortUrls->links() }}</div>

            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const copyButtons = document.querySelectorAll('.btn-copy');

                    copyButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const url = this.getAttribute('data-url');

                            navigator.clipboard.writeText(url).then(() => {
                                // Changement temporaire du texte du bouton
                                const originalText = button.innerHTML;
                                button.innerHTML = '<i class="fas fa-check"></i> Copié !';
                                button.classList.remove('btn-outline-secondary');
                                button.classList.add('btn-success');

                                // Réinitialisation après 2 secondes
                                setTimeout(() => {
                                    button.innerHTML = originalText;
                                    button.classList.remove('btn-success');
                                    button.classList.add('btn-outline-secondary');
                                }, 2000);

                            }).catch(err => {
                                console.error('Erreur lors de la copie : ', err);
                                alert('Impossible de copier le lien dans le presse-papier');
                            });
                        });
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    // Incrémenter pour le lien
                    document.querySelectorAll('.short-url-link').forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            const url = this.dataset.url;
                            const id = this.dataset.id;
                            incrementClicks(id).then(() => {
                                window.open(url, '_blank');
                            });
                        });
                    });

                    // Incrémenter pour copier
                    document.querySelectorAll('.btn-copy').forEach(btn => {
                        btn.addEventListener('click', async function() {
                            const url = this.dataset.url;
                            const id = this.dataset.id;
                            try {
                                await incrementClicks(id);
                                navigator.clipboard.writeText(url);
                                this.innerHTML = '<i class="fas fa-check"></i> Copié !';
                                setTimeout(() => this.innerHTML = '<i class="fas fa-copy"></i> Copier', 2000);
                            } catch (error) {
                                console.error('Erreur:', error);
                            }
                        });
                    });

                    window.incrementClicks = async function(id) {  // Rendre globale pour réutilisation
                        const response = await fetch(`/shorturls/${id}/increment-clicks`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const data = await response.json();

                        // ✅ MISE À JOUR INSTANTANÉE DU COMPTEUR
                        if (data.success && data.clicks !== undefined) {
                            const counterElement = document.querySelector(`.clicks-count[data-id="${id}"]`);
                            if (counterElement) {
                                counterElement.textContent = data.clicks;
                                // Effet visuel optionnel
                                counterElement.style.color = '#10b981';
                                setTimeout(() => counterElement.style.color = '', 500);
                            }
                        }

                        return data;
                    };
                });

            </script>
            @endpush
        </div>
    </div>
</x-app-layout>
