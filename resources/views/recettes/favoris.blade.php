@extends('layouts.app')

@section('content')
<style>
    .fav-page {
        background: radial-gradient(circle at 10% 4%, rgba(123, 76, 201, 0.09), transparent 38%), linear-gradient(180deg, #fcf9f7 0%, #f8f1ea 100%);
        border-radius: 20px;
        padding: 1rem;
    }
    .fav-panel { background: #fff; border: 1px solid #eee; border-radius: 16px; }
    .fav-title { font-family: "Playfair Display", serif; color: #064420; }
    .fav-card { border: 1px solid #eee; border-radius: 14px; overflow: hidden; transition: transform 0.2s ease; }
    .fav-card:hover { transform: translateY(-2px); }
    .fav-image { width: 100%; aspect-ratio: 16/10; object-fit: cover; }
    .fav-image-placeholder { background: #f3f4f6; color: #6f6f6f; }
    .fav-counter { background: #fff; border: 1px solid #f2c8bd; color: #e07a5f; border-radius: 999px; padding: 0.3rem 0.8rem; font-weight: 600; }
    .fav-chip { background: #fef6eb; color: #5b2e91; border: 1px solid #f2ddc5; border-radius: 999px; font-size: 0.78rem; padding: 0.25rem 0.65rem; }
    .theme-outline { border: 1px solid #fa8072; color: #fa8072; background: #fff; }
    .theme-outline:hover { background: #fa8072; color: #fff; border-color: #fa8072; }
    .fav-table thead th { background: #fef6eb; color: #5b2e91; border-bottom: 1px solid #f2ddc5; font-weight: 700; }
    .fav-table tbody tr:hover { background: #fffaf7; }
    .fade-in-up { animation: fadeInUp 0.45s ease both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(8px);} to { opacity: 1; transform: translateY(0);} }
</style>

<div class="fav-page">
    <section class="fav-panel p-4 p-lg-5 mb-4 fade-in-up">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
            <div>
                <h2 class="fav-title section-title mb-1">{{ ($modeAdminListe ?? false) ? __('messages.liste_favoris') : __('messages.mes_favoris') }}</h2>
                @if($modeAdminListe ?? false)
                    <p class="text-muted mb-0">{{ __('messages.favoris_admin_titre') }}</p>
                @else
                    <p class="text-muted mb-0">{{ __('messages.mes_favoris') }}</p>
                @endif
            </div>
            @if($modeAdminListe ?? false)
                <span class="fav-counter">{{ isset($favorisParRecette) ? $favorisParRecette->count() : 0 }} recette(s)</span>
            @else
                <span class="fav-counter">{{ isset($favoris) ? $favoris->count() : 0 }} favori(s)</span>
            @endif
        </div>
    </section>

    <section class="fav-panel p-4 p-lg-5 fade-in-up">
        @if($modeAdminListe ?? false)
            @if(isset($favorisParRecette) && $favorisParRecette->isNotEmpty())
                <div class="table-responsive">
                    <table class="table align-middle fav-table">
                        <thead>
                            <tr>
                                <th>Nom de la recette</th>
                                <th>{{ __('messages.categorie') }}</th>
                                <th>{{ __('messages.nombre_favoris') }}</th>
                                <th>Utilisateurs ayant ajoute en favori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($favorisParRecette as $listeFavoris)
                                @php
                                    $premierFavori = $listeFavoris->first();
                                    $recette = $premierFavori?->recette;
                                    $nomsUtilisateurs = $listeFavoris->map(function ($favori) {
                                        return $favori->user->name ?? __('messages.inconnu');
                                    })->unique()->implode(', ');
                                @endphp
                                <tr>
                                    <td>
                                        @if($recette)
                                            <a href="{{ route('recettes.detail', $recette->id) }}" class="text-decoration-none">{{ $recette->titre }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $recette->categorie->nom_categorie ?? '-' }}</td>
                                    <td>{{ $listeFavoris->count() }}</td>
                                    <td>{{ $nomsUtilisateurs ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <h4 class="mb-2">{{ __('messages.aucun_favori') }}</h4>
                    </div>
                </div>
            @endif
        @else
            <div class="row g-4">
                @forelse(($favoris ?? collect()) as $favori)
                    <div class="col-12 col-md-6 col-xl-4">
                        <article class="card fav-card h-100 border-0">
                            <div>
                                @if($favori->recette && $favori->recette->image)
                                    <img src="{{ asset('storage/' . $favori->recette->image) }}" class="fav-image" alt="{{ __('messages.image_recette_alt') }}">
                                @else
                                    <div class="fav-image fav-image-placeholder d-flex align-items-center justify-content-center">
                                        <span>{{ __('messages.no_image') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <span class="fav-chip">{{ $favori->recette->categorie->nom_categorie ?? '-' }}</span>
                                    <small class="text-muted">{{ $favori->date_ajout }}</small>
                                </div>
                                <h4 class="mb-2">{{ $favori->recette->titre ?? '-' }}</h4>
                                <p class="text-muted mb-4">{{ __('messages.auteur') }} : {{ $favori->recette->auteur ?? '-' }}</p>
                                <div class="mt-auto">
                                    @if($favori->recette)
                                        <a href="{{ route('recettes.detail', $favori->recette->id) }}" class="btn theme-outline rounded-pill px-3">{{ __('messages.voir_detail') }}</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <h4 class="mb-2">{{ __('messages.aucun_favori') }}</h4>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        @endif
    </section>
</div>
@endsection
