@extends('layouts.app')

@section('content')
<style>
    .mes-page {
        background: radial-gradient(circle at 10% 4%, rgba(123, 76, 201, 0.09), transparent 38%), linear-gradient(180deg, #fcf9f7 0%, #f8f1ea 100%);
        border-radius: 20px;
        padding: 1rem;
    }
    .mes-panel { background: #fff; border: 1px solid #eee; border-radius: 16px; }
    .mes-title { font-family: "Playfair Display", serif; color: #064420; }
    .recipe-card { border: 1px solid #eee; border-radius: 14px; overflow: hidden; }
    .recipe-card:hover { transform: translateY(-2px); transition: 0.2s ease; }
    .recipe-image { width: 100%; aspect-ratio: 16/10; object-fit: cover; }
    .recipe-image-placeholder { background: #f3f4f6; color: #6f6f6f; }
    .recipe-counter { background: #fff; border: 1px solid #f2c8bd; color: #e07a5f; border-radius: 999px; padding: 0.3rem 0.8rem; font-weight: 600; }
    .theme-outline { border: 1px solid #fa8072; color: #fa8072; background: #fff; }
    .theme-outline:hover { background: #fa8072; color: #fff; border-color: #fa8072; }
    .fade-in-up { animation: fadeInUp 0.45s ease both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(8px);} to { opacity: 1; transform: translateY(0);} }
</style>

<div class="mes-page">
<section class="mes-panel p-4 p-lg-5 mb-4 fade-in-up">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
        <div>
            <h2 class="mes-title section-title mb-1">{{ __('messages.mes_recettes') }}</h2>
            <p class="text-muted mb-0">{{ __('messages.mes_recettes_desc') }}</p>
        </div>
        <a href="{{ route('recettes.ajouter.form') }}" class="btn btn-warm rounded-pill px-4">{{ __('messages.ajouter_recette') }}</a>
    </div>
</section>

<section class="mes-panel p-4 p-lg-5 fade-in-up">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
        <h3 class="section-subtitle mb-0">{{ __('messages.mes_recettes') }}</h3>
        <span class="recipe-counter">{{ $recettes->count() }} recette(s)</span>
    </div>

    <div class="row g-4">
        @forelse($recettes as $recette)
            <div class="col-12 col-md-6 col-xl-4">
                <article class="card recipe-card h-100 border-0">
                    <div class="recipe-media">
                        @if($recette->image)
                            <img src="{{ asset('storage/' . $recette->image) }}" class="recipe-image" alt="{{ __('messages.image_recette_alt') }}">
                        @else
                            <div class="recipe-image recipe-image-placeholder d-flex align-items-center justify-content-center">
                                <span>{{ __('messages.no_image') }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <span class="badge text-bg-light border">{{ $recette->categorie->nom_categorie ?? '-' }}</span>
                            <small class="text-muted">#{{ $recette->id }}</small>
                        </div>
                        <h4 class="recipe-title">{{ $recette->titre }}</h4>
                        <p class="recipe-author mb-4">{{ __('messages.auteur') }} : {{ $recette->auteur }}</p>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('recettes.detail', $recette->id) }}" class="btn theme-outline rounded-pill px-3">{{ __('messages.voir_detail') }}</a>
                            <a href="{{ route('recettes.modifier.form', $recette->id) }}" class="btn theme-outline rounded-pill px-3">{{ __('messages.modifier') }}</a>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm empty-state-card">
                    <div class="card-body text-center py-5">
                        <h4 class="mb-2">{{ __('messages.aucune_recette_personnelle') }}</h4>
                        <p class="text-muted mb-3">{{ __('messages.aucune_recette_personnelle_desc') }}</p>
                        <a href="{{ route('recettes.ajouter.form') }}" class="btn btn-warm rounded-pill px-4">{{ __('messages.ajouter_recette') }}</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</section>
</div>
@endsection
