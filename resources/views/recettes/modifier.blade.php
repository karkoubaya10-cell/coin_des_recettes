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
        --line: #eee;
        --ink: #121212;
    }

    body {
        background: var(--offwhite);
        color: var(--ink);
        font-family: "Montserrat", sans-serif;
    }

    .recipe-form-page {
        background:
            radial-gradient(circle at 12% 6%, rgba(123, 76, 201, 0.1), transparent 40%),
            radial-gradient(circle at 88% 16%, rgba(212, 163, 115, 0.12), transparent 45%),
            linear-gradient(180deg, var(--offwhite) 0%, var(--sand) 100%);
        border-radius: 20px;
        padding: 1rem;
    }

    .recipe-form-page .form-shell {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
    }

    .recipe-form-page .section-title {
        font-family: "Playfair Display", serif;
        font-size: clamp(1.7rem, 2.8vw, 2.4rem);
        margin: 0;
        color: var(--forest);
    }

    .recipe-form-page .section-subtitle {
        font-family: "Playfair Display", serif;
        color: var(--forest);
        font-size: 1.3rem;
    }

    .recipe-form-page .intro-text {
        color: #6d6d6d;
        margin-bottom: 0;
    }

    .recipe-form-page .form-label {
        font-weight: 600;
        color: #252525;
        margin-bottom: 0.45rem;
    }

    .recipe-form-page .form-control,
    .recipe-form-page .form-select {
        border: 1px solid #e7ddd4;
        border-radius: 12px;
        padding: 0.68rem 0.85rem;
        background: #fff;
    }

    .recipe-form-page .form-control:focus,
    .recipe-form-page .form-select:focus {
        border-color: #c5b0e7;
        box-shadow: 0 0 0 0.2rem rgba(91, 46, 145, 0.16);
    }

    .recipe-form-page .form-text {
        color: #6e655d;
    }

    .recipe-form-page .alert-danger {
        border: 1px solid #f3c8c0;
        background: #fff7f5;
        color: #7f3c30;
        border-radius: 12px;
    }

    .recipe-form-page .step-card {
        border: 1px solid #efe6de;
        background: #fff;
        border-radius: 12px;
    }

    .recipe-form-page .step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.7rem;
        height: 1.7rem;
        border-radius: 50%;
        background: #f8efe8;
        color: #7f5620;
        font-size: 0.86rem;
        font-weight: 700;
        margin-left: 0.35rem;
    }

    .recipe-form-page .btn-soft-outline {
        border-radius: 999px;
        border: 1px solid var(--salmon);
        color: var(--salmon);
        background: #fff;
        font-weight: 600;
    }

    .recipe-form-page .btn-soft-outline:hover {
        background: var(--salmon);
        border-color: var(--salmon);
        color: #fff;
    }

    .recipe-form-page .btn-soft-fill {
        border-radius: 999px;
        border: 1px solid var(--salmon);
        background: var(--salmon);
        color: #fff;
        font-weight: 600;
    }

    .recipe-form-page .btn-soft-fill:hover {
        background: var(--salmon-deep);
        border-color: var(--salmon-deep);
        color: #fff;
    }

    .recipe-form-page .btn-step-remove {
        border-radius: 999px;
        border: 1px solid var(--terracotta);
        color: var(--terracotta);
        background: #fff;
    }

    .recipe-form-page .btn-step-remove:hover {
        background: var(--terracotta);
        border-color: var(--terracotta);
        color: #fff;
    }

    .recipe-form-page .current-image {
        max-width: 170px;
        border-radius: 12px;
        border: 1px solid #efe6de;
        padding: 4px;
        background: #fff;
    }
</style>

<div class="recipe-form-page">
    <div class="form-shell p-4 p-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-2">
            <h2 class="section-title mb-0">{{ __('messages.modifier_recette') }}</h2>
            <a href="{{ route('recettes.detail', $recette->id) }}" class="btn btn-soft-outline px-3">{{ __('messages.voir_detail') }}</a>
        </div>
        <p class="intro-text mb-4">{{ __('messages.form_modifier_intro') }}</p>

        @php
            $etapesFormulaire = old('etapes', $recette->etapes->pluck('description')->all());
            if (count($etapesFormulaire) === 0) {
                $etapesFormulaire = [''];
            }
        @endphp

        <form action="{{ route('recettes.modifier') }}" method="POST" enctype="multipart/form-data" class="row g-3" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $recette->id }}">

            <div class="col-md-6">
                <label for="auteur" class="form-label">{{ __('messages.auteur') }}</label>
                <input id="auteur" type="text" name="auteur" value="{{ old('auteur', $recette->auteur) }}" class="form-control @error('auteur') is-invalid @enderror" required>
                @error('auteur')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="titre" class="form-label">{{ __('messages.titre_recette') }}</label>
                <input id="titre" type="text" name="titre" value="{{ old('titre', $recette->titre) }}" class="form-control @error('titre') is-invalid @enderror" required>
                @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">{{ __('messages.description') }}</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $recette->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <label for="ingredients" class="form-label">{{ __('messages.ingredients') }}</label>
                <div class="form-text mb-2"><strong>{{ __('messages.nb') }}:</strong> {{ __('messages.ingredients_par_ligne') }}</div>
                <textarea id="ingredients" name="ingredients" class="form-control @error('ingredients') is-invalid @enderror" rows="5" required>{{ old('ingredients', $recette->ingredients) }}</textarea>
                @error('ingredients')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="temps_preparation" class="form-label">{{ __('messages.temps') }}</label>
                <input id="temps_preparation" type="number" name="temps_preparation" value="{{ old('temps_preparation', $recette->temps_preparation) }}" class="form-control @error('temps_preparation') is-invalid @enderror" min="1" required>
                @error('temps_preparation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="categorie_id" class="form-label">{{ __('messages.categorie') }}</label>
                <select id="categorie_id" name="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" required>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" @selected(old('categorie_id', $recette->categorie_id) == $categorie->id)>
                            {{ $categorie->nom_categorie }}
                        </option>
                    @endforeach
                </select>
                @error('categorie_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="image" class="form-label">{{ __('messages.image') }}</label>
                <input id="image" type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @if($recette->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $recette->image) }}" class="current-image" alt="{{ $recette->titre }}">
                    </div>
                @endif
            </div>

            <div class="col-12 pt-2">
                <h3 class="section-subtitle mb-3">{{ __('messages.etapes') }}</h3>
                <div id="liste-etapes" class="d-grid gap-2">
                    @foreach($etapesFormulaire as $index => $etape)
                        <div class="step-card bloc-etape">
                            <div class="p-3">
                                <label class="form-label fw-semibold mb-1">
                                    {{ __('messages.etape') }}
                                    <span class="numero-etape step-number">{{ $index + 1 }}</span>
                                </label>
                                <textarea name="etapes[]" class="form-control @if($errors->has('etapes') || $errors->has('etapes.'.$index)) is-invalid @endif" rows="2" required>{{ $etape }}</textarea>
                                <button type="button" class="btn btn-sm btn-step-remove mt-2 supprimer-etape">{{ __('messages.supprimer_etape') }}</button>
                                @if($errors->has('etapes.'.$index))
                                    <div class="invalid-feedback d-block">{{ $errors->first('etapes.'.$index) }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('etapes')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 d-flex flex-wrap gap-2 pt-2">
                <button type="button" id="ajouter-etape" class="btn btn-soft-outline px-3">{{ __('messages.ajouter_etape') }}</button>
                <button type="submit" class="btn btn-soft-fill px-4">{{ __('messages.modifier') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    const listeEtapes = document.getElementById('liste-etapes');
    const boutonAjouter = document.getElementById('ajouter-etape');

    function numeroterEtapes() {
        const blocs = document.querySelectorAll('.bloc-etape');
        blocs.forEach((bloc, index) => {
            bloc.querySelector('.numero-etape').textContent = index + 1;
        });
    }

    function creerBlocEtape() {
        const div = document.createElement('div');
        div.className = 'step-card bloc-etape';
        div.innerHTML =
            '<div class="p-3">' +
            '<label class="form-label fw-semibold mb-1">{{ __('messages.etape') }} <span class="numero-etape step-number"></span></label>' +
            '<textarea name="etapes[]" class="form-control" rows="2" required></textarea>' +
            '<button type="button" class="btn btn-sm btn-step-remove mt-2 supprimer-etape">{{ __('messages.supprimer_etape') }}</button>' +
            '</div>';

        return div;
    }

    boutonAjouter.addEventListener('click', () => {
        listeEtapes.appendChild(creerBlocEtape());
        numeroterEtapes();
    });

    listeEtapes.addEventListener('click', (event) => {
        if (!event.target.classList.contains('supprimer-etape')) {
            return;
        }

        const blocs = document.querySelectorAll('.bloc-etape');
        if (blocs.length > 1) {
            event.target.closest('.bloc-etape').remove();
            numeroterEtapes();
        }
    });

    numeroterEtapes();
</script>
@endsection
