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
        --soft-line: #eee;
        --anthracite: #333;
        --gf-bg: #f9e8e4;
    }

    body {
        background: var(--offwhite);
        color: var(--ink);
        font-family: "Montserrat", sans-serif;
    }

    .mini-navbar {
        background: #FEEAE6 !important;
        border-bottom: 1px solid #f2c8bd !important;
    }

    .mb-home-wrap {
        color: var(--ink);
        background:
            radial-gradient(circle at 8% 8%, rgba(123, 76, 201, 0.1), transparent 40%),
            radial-gradient(circle at 92% 18%, rgba(212, 163, 115, 0.13), transparent 42%),
            linear-gradient(180deg, var(--offwhite) 0%, var(--sand) 65%, var(--offwhite) 100%);
        border-radius: 20px;
        padding: 0.35rem 0.9rem 1.2rem;
    }

    .main-content {
        padding-top: 0.75rem !important;
    }

    .mb-hero {
        background: linear-gradient(180deg, #fff 0%, var(--sand) 100%);
        border: 1px solid var(--soft-line);
        border-radius: 16px;
        text-align: center;
        padding: 1.7rem 0 1.7rem;
    }

    .mb-title {
        font-family: "Playfair Display", serif;
        font-size: clamp(2rem, 5vw, 3.5rem);
        letter-spacing: 0.05em;
        margin-bottom: 0.65rem;
    }

    .mb-subtitle {
        max-width: 52ch;
        margin: 0 auto 1.2rem;
        color: #5f5f5f;
    }

    .mb-hero-image {
        position: relative;
        max-width: 980px;
        margin: 0 auto;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid var(--soft-line);
        box-shadow: 0 18px 40px rgba(91, 46, 145, 0.12), 0 6px 18px rgba(18, 18, 18, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .mb-hero-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(91, 46, 145, 0.06));
        pointer-events: none;
        z-index: 2;
    }

    .mb-hero-image:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 44px rgba(91, 46, 145, 0.14), 0 8px 22px rgba(18, 18, 18, 0.1);
    }

    .mb-hero-image img {
        width: 100%;
        height: 420px;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .mb-hero-image:hover img {
        transform: scale(1.015);
    }

    .mb-btn-primary {
        background: var(--salmon);
        border: 1px solid var(--salmon);
        color: #fff;
        border-radius: 999px;
        padding: 0.55rem 1.25rem;
        font-size: 0.84rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-weight: 600;
    }

    .mb-btn-primary:hover {
        background: var(--salmon-deep);
        border-color: var(--salmon-deep);
        color: #fff;
    }

    .mb-btn-secondary {
        background: #fff;
        border: 1px solid var(--soft-line);
        color: var(--ink);
        border-radius: 999px;
        padding: 0.55rem 1.25rem;
        font-size: 0.84rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-weight: 600;
    }

    .mb-btn-secondary:hover {
        border-color: var(--salmon);
        color: var(--salmon-deep);
    }

    .mb-filter-wrap {
        background: var(--sand);
        border: 1px solid var(--soft-line);
        border-radius: 16px;
        padding: 1.1rem;
        margin: 1rem 0 1.8rem;
    }

    #titre-liste-recettes {
        scroll-margin-top: 145px;
    }

    .mb-filter-pill {
        border-radius: 999px;
        border: 1px solid #e7ddd4;
        background: #fff;
        color: #6d665f;
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        transition: all 0.2s ease;
    }

    .mb-filter-wrap a:nth-child(5n+1):hover {
        background: var(--coral);
        border-color: var(--coral);
        color: #fff;
    }

    .mb-filter-wrap a:nth-child(5n+2):hover {
        background: var(--terracotta);
        border-color: var(--terracotta);
        color: #fff;
    }

    .mb-filter-wrap a:nth-child(5n+3):hover {
        background: var(--forest);
        border-color: var(--forest);
        color: #fff;
    }

    .mb-filter-wrap a:nth-child(5n+4):hover {
        background: var(--mustard);
        border-color: var(--mustard);
        color: #fff;
    }

    .mb-filter-wrap a:nth-child(5n):hover {
        background: var(--anthracite);
        border-color: var(--anthracite);
        color: #fff;
    }

    .mb-filter-pill.active {
        background: var(--terracotta);
        border-color: var(--terracotta);
        color: #fff;
    }

    .mb-recipes-headline {
        font-family: "Playfair Display", serif;
        font-size: 1.9rem;
        margin-bottom: 1.35rem;
        color: var(--forest);
    }

    .mb-recipe-card {
        border: 1px solid var(--soft-line);
        border-radius: 14px;
        background: #fff;
        transition: transform 0.2s ease;
        overflow: hidden;
    }

    .mb-recipe-card:hover {
        transform: translateY(-3px);
    }

    .mb-home-wrap .row > div:nth-child(4n+1) .mb-recipe-card {
        border-top: 3px solid var(--terracotta);
    }

    .mb-home-wrap .row > div:nth-child(4n+2) .mb-recipe-card {
        border-top: 3px solid var(--coral);
    }

    .mb-home-wrap .row > div:nth-child(4n+3) .mb-recipe-card {
        border-top: 3px solid var(--forest);
    }

    .mb-home-wrap .row > div:nth-child(4n) .mb-recipe-card {
        border-top: 3px solid var(--mustard);
    }

    .mb-square-image {
        aspect-ratio: 1 / 1;
        width: 100%;
        object-fit: cover;
        border-radius: 12px;
    }

    .mb-image-placeholder {
        aspect-ratio: 1 / 1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--pearl);
        border: 1px solid var(--soft-line);
        color: #6f6f6f;
    }

    .mb-recipe-title {
        color: #0f0f0f;
        font-size: 1.03rem;
        font-weight: 700;
        text-align: center;
        min-height: 2.8rem;
        margin-bottom: 0.35rem;
    }

    .mb-recipe-category {
        text-align: center;
        color: var(--terracotta);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.35rem;
    }

    .mb-home-wrap .row > div:nth-child(4n+2) .mb-recipe-category {
        color: var(--coral);
    }

    .mb-home-wrap .row > div:nth-child(4n+3) .mb-recipe-category {
        color: var(--forest);
    }

    .mb-home-wrap .row > div:nth-child(4n) .mb-recipe-category {
        color: var(--mustard);
    }

    .mb-recipe-meta {
        font-size: 0.83rem;
        color: #6f6f6f;
        text-align: center;
        margin-bottom: 0.85rem;
    }

    .mb-link-btn {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .mb-link-btn:hover {
        border-color: var(--forest);
        color: var(--forest);
        background: #fff;
    }

    .mb-why {
        margin: 2rem 0 1.9rem;
        padding: 1.35rem;
        border: 1px solid var(--soft-line);
        border-radius: 16px;
        background: linear-gradient(180deg, #fff 0%, #fdf6f4 100%);
    }

    .mb-why-title {
        font-family: "Playfair Display", serif;
        text-align: center;
        font-size: clamp(1.45rem, 3vw, 2rem);
        color: var(--terracotta);
        margin-bottom: 1rem;
    }

    .mb-why-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 0.8rem;
    }

    .mb-why-item {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        background: #fff;
        border: 1px solid #efe4dd;
        border-radius: 12px;
        padding: 0.8rem 0.9rem;
        font-weight: 500;
        color: #4b3a35;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .mb-why-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(91, 46, 145, 0.08);
    }

    .mb-why-icon {
        width: 1.7rem;
        height: 1.7rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(123, 76, 201, 0.12);
        color: var(--terracotta);
        font-size: 0.95rem;
        flex: 0 0 auto;
    }

    .mb-why-item:nth-child(2n) .mb-why-icon {
        background: rgba(212, 163, 115, 0.18);
        color: #8a5a2f;
    }

    @media (max-width: 991.98px) {
        .mb-hero-image img {
            height: 300px;
        }
    }

    @media (min-width: 768px) {
        .mb-why-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1100px) {
        .mb-why-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
</style>

<div class="mb-home-wrap">
    <section class="mb-hero">
        <h1 class="mb-title">{{ __('messages.hero_recettes') }}</h1>
        <p class="mb-subtitle">{{ __('messages.hero_sous_titre') }}</p>
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
            <a href="{{ route('recettes.liste') }}#titre-liste-recettes" class="btn mb-btn-secondary">{{ __('messages.liste') }}</a>
            <a href="{{ route('recettes.ajouter.form') }}" class="btn mb-btn-primary">{{ __('messages.ajouter_recette') }}</a>
        </div>
        <div class="mb-hero-image">
            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=1600&q=80" alt="{{ __('messages.hero_image_alt') }}">
        </div>
    </section>

    <section class="mb-why">
        <h2 class="mb-why-title">{{ __('messages.why_title') }}</h2>
        <div class="mb-why-grid">
            <div class="mb-why-item"><span class="mb-why-icon">✓</span><span>{{ __('messages.why_1') }}</span></div>
            <div class="mb-why-item"><span class="mb-why-icon">✓</span><span>{{ __('messages.why_2') }}</span></div>
            <div class="mb-why-item"><span class="mb-why-icon">✓</span><span>{{ __('messages.why_3') }}</span></div>
            <div class="mb-why-item"><span class="mb-why-icon">✓</span><span>{{ __('messages.why_4') }}</span></div>
            <div class="mb-why-item"><span class="mb-why-icon">✓</span><span>{{ __('messages.why_5') }}</span></div>
            <div class="mb-why-item"><span class="mb-why-icon">✓</span><span>{{ __('messages.why_6') }}</span></div>
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section id="filtres-categories">
        <h2 id="titre-liste-recettes" class="mb-recipes-headline text-center">{{ __('messages.liste') }}</h2>
    </section>

    <section class="mb-filter-wrap">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="{{ route('recettes.liste') }}" class="btn mb-filter-pill {{ !$categorieChoisie ? 'active' : '' }}">
                {{ __('messages.tout') }}
            </a>
            @foreach($categories as $categorie)
                <a href="{{ route('recettes.liste', ['categorie' => $categorie->id]) }}#titre-liste-recettes" class="btn mb-filter-pill {{ (string) $categorieChoisie === (string) $categorie->id ? 'active' : '' }}">
                    {{ $categorie->nom_categorie }}
                </a>
            @endforeach
        </div>
    </section>

    <section>
        <div class="row g-4">
            @forelse($recettes as $recette)
                <div class="col-12 col-md-4 col-lg-3">
                    <article class="card mb-recipe-card h-100">
                        @if($recette->image)
                            <img src="{{ asset('storage/' . $recette->image) }}" class="mb-square-image" alt="{{ __('messages.image_recette_alt') }}">
                        @else
                            <div class="mb-image-placeholder">{{ __('messages.no_image') }}</div>
                        @endif

                        <div class="card-body px-1 pb-0 d-flex flex-column">
                            <h3 class="mb-recipe-title">{{ $recette->titre }}</h3>
                            <div class="mb-recipe-category">{{ $recette->categorie->nom_categorie ?? '-' }}</div>
                            <p class="mb-recipe-meta">{{ __('messages.auteur') }} : {{ $recette->auteur }}</p>

                            <div class="text-center mt-auto pb-2">
                                <a href="{{ route('recettes.detail', $recette->id) }}" class="btn btn-sm mb-btn-secondary mb-link-btn">{{ __('messages.voir_detail') }}</a>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-light rounded-3 border">
                        <h4 class="mb-2">{{ __('messages.aucune_recette') }}</h4>
                        <p class="text-muted mb-0">{{ __('messages.aucune_recette_hint') }}</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
