@extends('layouts.app')

@section('content')
<style>
    :root {
        --coral: #7B4CC9;
        --terracotta: #5B2E91;
        --salmon: #FA8072;
        --salmon-deep: #E07A5F;
        --forest: #064420;
        --mustard: #D4A373;
        --offwhite: #FCF9F7;
        --sand: #F8F1EA;
        --pearl: #F3F4F6;
        --ink: #121212;
        --line: #eee;
        --anthracite: #333;
    }

    body {
        background: var(--offwhite);
        color: var(--ink);
        font-family: "Montserrat", sans-serif;
    }

    .recipe-detail-page {
        --text-soft: #6f6f6f;
        background:
            radial-gradient(circle at 10% 5%, rgba(123, 76, 201, 0.1), transparent 40%),
            radial-gradient(circle at 90% 15%, rgba(212, 163, 115, 0.12), transparent 45%),
            linear-gradient(180deg, var(--offwhite) 0%, var(--sand) 100%);
        border-radius: 20px;
        padding: 1rem;
    }

    .recipe-detail-page .recipe-panel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
    }

    .recipe-detail-page .recipe-title {
        font-family: "Playfair Display", serif;
        font-size: clamp(2rem, 3.4vw, 3rem);
        line-height: 1.12;
        margin: 0;
    }

    .recipe-detail-page .recipe-subtitle {
        color: var(--text-soft);
        font-size: 0.95rem;
        margin-top: 0.5rem;
    }

    .recipe-detail-page .time-badge {
        display: inline-flex;
        align-items: center;
        border: 1px solid #e8c8a6;
        color: #7f5620;
        background: #fef6eb;
        border-radius: 999px;
        padding: 0.45rem 0.95rem;
        font-weight: 600;
        font-size: 0.88rem;
        letter-spacing: 0.02em;
    }

    .recipe-detail-page .recipe-hero {
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid var(--line);
    }

    .recipe-detail-page .section-title {
        font-family: "Playfair Display", serif;
        font-size: 1.45rem;
        margin-bottom: 0.75rem;
        color: var(--forest);
    }

    .recipe-detail-page .ingredients-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .recipe-detail-page .ingredients-list li {
        position: relative;
        padding-left: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .recipe-detail-page .ingredients-list li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0.6rem;
        width: 0.42rem;
        height: 0.42rem;
        border-radius: 50%;
        background: var(--terracotta);
    }

    .recipe-detail-page .steps-list {
        margin-bottom: 0;
        padding-left: 1.3rem;
    }

    .recipe-detail-page .steps-list li {
        margin-bottom: 0.75rem;
        padding-left: 0.35rem;
    }

    .recipe-detail-page .steps-list li::marker {
        color: var(--forest);
        font-weight: 700;
    }

    .recipe-detail-page .sidebar-card {
        border: 1px solid var(--line);
        border-radius: 14px;
        background: #fff;
    }

    .recipe-detail-page .sidebar-card.inspiration-card {
        background: var(--sand);
    }

    .recipe-detail-page .sidebar-title {
        font-family: "Playfair Display", serif;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .recipe-detail-page .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem;
    }

    .recipe-detail-page .stat-box {
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 0.8rem;
        text-align: center;
    }

    .recipe-detail-page .stat-value {
        font-size: 1.45rem;
        line-height: 1;
        color: var(--mustard);
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .recipe-detail-page .stat-box:nth-child(2) .stat-value {
        color: var(--terracotta);
    }

    .recipe-detail-page .stat-label {
        color: var(--text-soft);
        font-size: 0.82rem;
    }

    .recipe-detail-page .btn-minimal {
        border-radius: 999px;
        border: 1px solid #bda7e6;
        color: #6f4ea8;
        font-weight: 600;
        background: #fff;
        transition: all 0.2s ease;
    }

    .recipe-detail-page .btn-minimal:hover {
        background: #bda7e6;
        color: #fff;
        border-color: #bda7e6;
        transform: translateY(-1px);
    }

    .recipe-detail-page .btn-accent {
        border-radius: 999px;
        border: 1px solid var(--salmon);
        background: var(--salmon);
        color: #fff;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .recipe-detail-page .btn-accent:hover {
        background: var(--salmon-deep);
        border-color: var(--salmon-deep);
        color: #fff;
        transform: translateY(-1px);
    }

    .recipe-detail-page .btn-outline-danger {
        background: #fff;
        border-color: var(--salmon);
        color: var(--salmon);
    }

    .recipe-detail-page .btn-outline-danger:hover {
        background: var(--salmon);
        border-color: var(--salmon);
        color: #fff;
    }

    /* Keep the 4 "Actions" buttons in purple */
    .recipe-detail-page .sidebar-card .btn-accent {
        border: 1px solid #bda7e6;
        background: #bda7e6;
        color: #fff;
    }

    .recipe-detail-page .sidebar-card .btn-accent:hover {
        background: #9c7fd4;
        border-color: #9c7fd4;
    }

    .recipe-detail-page .sidebar-card .btn-outline-danger {
        background: #fff;
        border-color: #bda7e6;
        color: #6f4ea8;
    }

    .recipe-detail-page .sidebar-card .btn-outline-danger:hover {
        background: #bda7e6;
        border-color: #bda7e6;
        color: #fff;
    }

    .recipe-detail-page .comment-box {
        border-top: 1px solid var(--line);
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .recipe-detail-page .comment-box:first-child {
        margin-top: 0;
        padding-top: 0;
        border-top: 0;
    }

    .recipe-detail-page .comment-meta {
        color: var(--text-soft);
        font-size: 0.86rem;
    }

    .recipe-detail-page .comment-input {
        border: 1px solid var(--line);
        border-radius: 12px;
        resize: vertical;
    }

    .recipe-detail-page .comment-input:focus {
        border-color: #c5b0e7;
        box-shadow: 0 0 0 0.2rem rgba(91, 46, 145, 0.16);
    }

    .recipe-detail-page .back-link {
        border: 1px solid var(--salmon);
        border-radius: 999px;
        color: #fff;
        background: linear-gradient(135deg, var(--mustard), var(--salmon));
        text-decoration: none;
        padding: 0.72rem 1.1rem;
        display: inline-flex;
        align-items: center;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .recipe-detail-page .back-link:hover {
        border-color: var(--salmon-deep);
        background: linear-gradient(135deg, var(--salmon), var(--salmon-deep));
        color: #fff;
        transform: translateY(-1px);
    }
</style>

<div class="recipe-detail-page">
    <div class="row g-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

        </div>

        <div class="col-lg-8">
            <article class="recipe-panel p-3 p-md-4 p-lg-5 h-100">
                <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
                    <div>
                        <h1 class="recipe-title">{{ $recette->titre }}</h1>
                        <p class="recipe-subtitle mb-0">
                            {{ __('messages.auteur') }}: {{ $recette->auteur }}
                            <span class="mx-1">|</span>
                            {{ __('messages.categorie') }}: {{ $recette->categorie->nom_categorie ?? '-' }}
                        </p>
                    </div>
                    <span class="time-badge"><span class="me-1" aria-hidden="true">&#128337;</span>{{ $recette->temps_preparation }} min</span>
                </div>

                @if($recette->image)
                    <img
                        src="{{ asset('storage/' . $recette->image) }}"
                        alt="{{ $recette->titre }}"
                        class="recipe-hero mb-4"
                    >
                @endif

                <section class="mb-4">
                    <h2 class="section-title">{{ __('messages.description') }}</h2>
                    <p class="mb-0">{{ $recette->description }}</p>
                </section>

                <section class="mb-4">
                    <h2 class="section-title">{{ __('messages.ingredients') }}</h2>
                    @php
                        $listeIngredients = preg_split('/\r\n|\r|\n/', $recette->ingredients);
                        $listeIngredients = array_filter(array_map('trim', $listeIngredients));
                    @endphp
                    @if(count($listeIngredients) > 0)
                        <ul class="ingredients-list">
                            @foreach($listeIngredients as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mb-0">{{ $recette->ingredients }}</p>
                    @endif
                </section>

                <section>
                    <h2 class="section-title">{{ __('messages.etapes') }}</h2>
                    @if($recette->etapes->isNotEmpty())
                        <ol class="steps-list">
                            @foreach($recette->etapes as $etape)
                                <li>{{ $etape->description }}</li>
                            @endforeach
                        </ol>
                    @else
                        <p class="mb-0 text-muted">{{ __('messages.aucune_etape') }}</p>
                    @endif
                </section>
            </article>
        </div>

        <div class="col-lg-4">
            <aside class="d-grid gap-3">
                <div class="sidebar-card inspiration-card p-3 p-md-4">
                    <h3 class="sidebar-title">{{ __('messages.recette_suggeree') }}</h3>
                    @if($inspirationCuisine)
                        <p class="mb-1"><strong>{{ __('messages.nom') }}:</strong> {{ $inspirationCuisine['nom'] ?? '-' }}</p>
                        <p class="mb-1"><strong>{{ __('messages.categorie_api') }}:</strong> {{ $inspirationCuisine['categorie'] ?? '-' }}</p>
                        <p class="mb-3"><strong>{{ __('messages.origine_api') }}:</strong> {{ $inspirationCuisine['origine'] ?? '-' }}</p>
                        @if(!empty($inspirationCuisine['image']))
                            <img src="{{ $inspirationCuisine['image'] }}" alt="{{ $inspirationCuisine['nom'] ?? __('messages.inspiration') }}" class="img-fluid rounded-3 border">
                        @endif
                    @else
                        <p class="text-muted mb-0">{{ __('messages.api_indisponible') }}</p>
                    @endif
                </div>

                <div class="sidebar-card p-3 p-md-4">
                    <h3 class="sidebar-title mb-3">{{ __('messages.stats') }}</h3>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-value"><span aria-hidden="true">&#10084;</span> {{ $nombreFavoris }}</div>
                            <div class="stat-label">{{ __('messages.nombre_favoris') }}</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-value"><span aria-hidden="true">&#128172;</span> {{ $nombreCommentaires }}</div>
                            <div class="stat-label">{{ __('messages.nombre_commentaires') }}</div>
                        </div>
                    </div>
                </div>

                @auth
                    <div class="sidebar-card p-3 p-md-4">
                        <h3 class="sidebar-title mb-3">{{ __('messages.actions') }}</h3>
                        <div class="d-grid gap-2">
                            <a href="{{ route('recettes.pdf', $recette->id) }}" class="btn btn-minimal">
                                {{ __('messages.telecharger_pdf') }}
                            </a>

                            <form action="{{ route('favoris.toggle', $recette->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-accent w-100">
                                    <span aria-hidden="true" class="me-1">&#10084;</span>
                                    {{ $estFavori ? __('messages.retirer_favori') : __('messages.ajouter_favori') }}
                                </button>
                            </form>

                            @if(auth()->user()->role === 'admin' || auth()->id() === $recette->user_id)
                                <a href="{{ route('recettes.modifier.form', $recette->id) }}" class="btn btn-minimal">
                                    {{ __('messages.modifier') }}
                                </a>
                                <form
                                    action="{{ route('recettes.supprimer', $recette->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('{{ __('messages.confirmer_suppression') }}')"
                                >
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-outline-danger rounded-pill w-100">
                                        {{ __('messages.supprimer') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endauth
            </aside>
        </div>

        <div class="col-12">
            <section class="recipe-panel p-3 p-md-4 p-lg-5">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <h2 class="section-title mb-0">{{ __('messages.commentaires') }} ({{ $nombreCommentaires }})</h2>
                </div>

                @auth
                    <form action="{{ route('commentaires.ajouter', $recette->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-2">
                            <textarea
                                id="contenu"
                                name="contenu"
                                class="form-control comment-input @error('contenu') is-invalid @enderror"
                                rows="4"
                                placeholder="{{ __('messages.ajouter_commentaire') }}"
                                required
                            >{{ old('contenu') }}</textarea>
                            @error('contenu')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-accent px-4">{{ __('messages.ajouter_commentaire') }}</button>
                    </form>
                @endauth

                @if($recette->commentaires->isNotEmpty())
                    @foreach($recette->commentaires as $commentaire)
                        <article class="comment-box">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <p class="comment-meta mb-0">
                                    <strong>{{ $commentaire->user->name ?? __('messages.inconnu') }}</strong>
                                    <span class="mx-1">-</span>
                                    {{ $commentaire->date_commentaire }}
                                </p>
                                @auth
                                    @if(auth()->user()->role === 'admin' || auth()->id() === $commentaire->user_id)
                                        <form action="{{ route('commentaires.supprimer', $commentaire->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                {{ __('messages.supprimer_commentaire') }}
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                            <p class="mb-0 mt-2">{{ $commentaire->contenu }}</p>
                        </article>
                    @endforeach
                @else
                    <p class="mb-0 text-muted">{{ __('messages.aucun_commentaire') }}</p>
                @endif
            </section>
        </div>

        <div class="col-12">
            <a href="{{ route('recettes.liste') }}#titre-liste-recettes" class="back-link">{{ __('messages.retour_liste') }}</a>
        </div>
    </div>
</div>
@endsection
