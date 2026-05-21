@extends('layouts.app')

@section('content')
<style>
    .stats-page { background: radial-gradient(circle at 10% 4%, rgba(123, 76, 201, 0.09), transparent 38%), linear-gradient(180deg, #fcf9f7 0%, #f8f1ea 100%); border-radius: 20px; padding: 1rem; }
    .stats-panel { background: #fff; border: 1px solid #eee; border-radius: 16px; }
    .stats-table thead th { background: #fef6eb; color: #5b2e91; border-bottom: 1px solid #f2ddc5; }
    .stats-table tbody tr:hover { background: #fffaf7; }
    .theme-outline { border: 1px solid #fa8072; color: #fa8072; background: #fff; }
    .theme-outline:hover { background: #fa8072; color: #fff; border-color: #fa8072; }
    .fade-in-up { animation: fadeInUp 0.45s ease both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(8px);} to { opacity: 1; transform: translateY(0);} }
</style>
<div class="stats-page">
<div class="stats-panel p-4 p-lg-5 fade-in-up">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
            <div>
                <h2 class="section-title mb-1">{{ __('messages.stats_procedure_titre') }}</h2>
                <p class="text-muted mb-0">{{ __('messages.stats_procedure_desc') }}</p>
            </div>
            <a href="{{ route('recettes.liste') }}#titre-liste-recettes" class="btn theme-outline rounded-pill px-3">{{ __('messages.retour_liste') }}</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle stats-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.categorie') }}</th>
                        <th>{{ __('messages.total_recettes') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats as $ligne)
                        <tr>
                            <td>{{ $ligne->nom_categorie }}</td>
                            <td>{{ $ligne->total_recettes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">{{ __('messages.aucune_stat') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
