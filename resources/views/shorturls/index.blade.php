@extends('layouts.app')

@section('title', 'Mes liens raccourcis')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="margin: 0;">Mes liens raccourcis</h2>
        <a href="{{ route('shorturls.create') }}">
            <button type="button" class="btn">Ajouter un lien</button>
        </a>
    </div>

    <div class="card" style="overflow-x-auto; padding: 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f9fafb;">
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">ID</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">URL originale</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">URL courte</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Nb Cliques</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shortUrls as $shortUrl)
                    @php
                        $shortUrlFull = url('/r/'.$shortUrl->code);
                    @endphp
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 1rem; text-align: center;">{{ $shortUrl->id }}</td>
                        <td style="padding: 1rem;">
                            <a href="{{ $shortUrl->original_url }}" target="_blank" style="color: #3b82f6; text-decoration: none;">
                                {{ Str::limit($shortUrl->original_url, 50) }}
                            </a>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <a href="#" class="short-url-link" style="color: #3b82f6; text-decoration: none;"
                                   data-url="{{ $shortUrlFull }}" data-id="{{ $shortUrl->id }}">{{ $shortUrlFull }}</a>
                                <button type="button" class="btn-copy" style="padding: 0.25rem 0.5rem; background-color: #e5e7eb; border: none; border-radius: 4px; cursor: pointer; font-size: 0.875rem;"
                                        data-url="{{ $shortUrlFull }}" data-id="{{ $shortUrl->id }}">
                                    Copier
                                </button>
                            </div>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <span class="clicks-count" style="font-weight: 600;" data-id="{{ $shortUrl->id }}">{{ $shortUrl->clicks }}</span>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('shorturls.edit', $shortUrl) }}" style="color: #3b82f6; text-decoration: none;">
                                    Éditer
                                </a>
                                <form action="{{ route('shorturls.destroy', $shortUrl) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer ce lien ?')" style="color: #ef4444; background: none; border: none; cursor: pointer; text-decoration: underline;">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">Aucun lien pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem; text-align: center;">
        {{ $shortUrls->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('.btn-copy');

    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');

            navigator.clipboard.writeText(url).then(() => {
                const originalText = button.innerHTML;
                button.innerHTML = 'Copié !';
                button.style.backgroundColor = '#10b981';
                button.style.color = 'white';

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.backgroundColor = '#e5e7eb';
                    button.style.color = '';
                }, 2000);

            }).catch(err => {
                console.error('Erreur lors de la copie : ', err);
                alert('Impossible de copier le lien dans le presse-papier');
            });
        });
    });

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

    document.querySelectorAll('.btn-copy').forEach(btn => {
        btn.addEventListener('click', async function() {
            const url = this.dataset.url;
            const id = this.dataset.id;
            try {
                await incrementClicks(id);
                navigator.clipboard.writeText(url);
                this.innerHTML = 'Copié !';
                this.style.backgroundColor = '#10b981';
                this.style.color = 'white';
                setTimeout(() => {
                    this.innerHTML = 'Copier';
                    this.style.backgroundColor = '#e5e7eb';
                    this.style.color = '';
                }, 2000);
            } catch (error) {
                console.error('Erreur:', error);
            }
        });
    });

    window.incrementClicks = async function(id) {
        const response = await fetch(`/shorturls/${id}/increment-clicks`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        const data = await response.json();

        if (data.success && data.clicks !== undefined) {
            const counterElement = document.querySelector(`.clicks-count[data-id="${id}"]`);
            if (counterElement) {
                counterElement.textContent = data.clicks;
                counterElement.style.color = '#10b981';
                setTimeout(() => counterElement.style.color = '', 500);
            }
        }

        return data;
    };
});
</script>
@endsection
