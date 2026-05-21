@extends('layouts.app')

@section('content')
<style>
    .archives-page { background: radial-gradient(circle at 10% 4%, rgba(123, 76, 201, 0.09), transparent 38%), linear-gradient(180deg, #fcf9f7 0%, #f8f1ea 100%); border-radius: 20px; padding: 1rem; }
    .archives-panel { background: #fff; border: 1px solid #eee; border-radius: 16px; }
    .archives-table thead th { background: #fef6eb; color: #5b2e91; border-bottom: 1px solid #f2ddc5; white-space: nowrap; }
    .archives-table tbody tr:hover { background: #fffaf7; }
    .theme-outline { border: 1px solid #fa8072; color: #fa8072; background: #fff; }
    .theme-outline:hover { background: #fa8072; color: #fff; border-color: #fa8072; }
    .theme-danger { border: 1px solid #dc3545; color: #dc3545; background: #fff; }
    .theme-danger:hover { background: #dc3545; color: #fff; border-color: #dc3545; }
    .fade-in-up { animation: fadeInUp 0.45s ease both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(8px);} to { opacity: 1; transform: translateY(0);} }
</style>

<div class="archives-page">
    <div class="archives-panel p-4 p-lg-5 fade-in-up">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h2 class="section-title mb-1">{{ __('messages.archives_titre') }}</h2>
                <p class="text-muted mb-0">
                    {{ __('messages.archives_desc') }}
                    <span class="fw-semibold">({{ $archives->count() }} {{ __('messages.total_recettes') }})</span>
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('recettes.liste') }}#titre-liste-recettes" class="btn theme-outline rounded-pill px-3">
                    {{ __('messages.retour_liste') }}
                </a>
                <form method="POST" action="{{ route('archives.clear') }}" onsubmit="return confirm('{{ __('messages.confirmer_vidage_archives') }}');">
                    @csrf
                    <button type="submit" class="btn theme-danger rounded-pill px-3">
                        {{ __('messages.vider_archives') }}
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle archives-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.titre_col') }}</th>
                        <th>{{ __('messages.auteur') }}</th>
                        <th>{{ __('messages.categorie') }}</th>
                        <th>{{ __('messages.date_archivage') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archives as $archive)
                        <tr>
                            <td class="fw-semibold">{{ $archive->titre }}</td>
                            <td>{{ $archive->auteur }}</td>
                            <td>{{ $archive->nom_categorie ?? '-' }}</td>
                            <td>{{ $archive->date_archivage }}</td>
                            <td>
                                <form method="POST" action="{{ route('archives.destroy', $archive->id) }}" onsubmit="return confirm('{{ __('messages.confirmer_suppression_archive') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm theme-danger rounded-pill px-3">
                                        {{ __('messages.supprimer') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">{{ __('messages.aucune_archive') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
