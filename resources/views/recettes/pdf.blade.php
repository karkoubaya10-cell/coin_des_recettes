<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $recette->titre }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #2f2f2f;
            margin: 0;
            padding: 0;
            background: #fffaf7;
        }

        .page {
            padding: 26px 30px;
        }

        .brand-header {
            background: #FEEAE6;
            border: 1px solid #f3c7bb;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }

        .brand-row {
            width: 100%;
        }

        .brand-text-cell {
            vertical-align: middle;
        }

        .site-name {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: #b84f33;
            margin: 0;
        }

        .tagline {
            margin: 5px 0 0;
            font-size: 11px;
            color: #5e514d;
        }

        .recipe-title {
            font-size: 24px;
            margin: 0 0 8px;
            color: #2f2f2f;
        }

        .meta-box {
            background: #ffffff;
            border: 1px solid #f1e2dc;
            border-left: 4px solid #E97451;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 14px;
        }

        .meta {
            margin: 4px 0;
            color: #4b4b4b;
        }

        .section {
            background: #ffffff;
            border: 1px solid #efe5e1;
            border-radius: 8px;
            padding: 12px 14px;
            margin-top: 12px;
        }

        .section h2 {
            margin: 0 0 8px;
            font-size: 14px;
            color: #b84f33;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .image-wrap {
            margin: 12px 0;
            text-align: center;
        }

        .image-wrap img {
            max-width: 100%;
            max-height: 270px;
            border-radius: 8px;
            border: 1px solid #ecd7cf;
        }

        ul, ol {
            margin: 0;
            padding-left: 18px;
        }

        li {
            margin-bottom: 4px;
        }

        .footer-note {
            margin-top: 16px;
            text-align: center;
            color: #7a706b;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="brand-header">
            <table class="brand-row" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td class="brand-text-cell">
                        <p class="site-name">{{ config('app.name', 'Coin des recettes') }}</p>
                    </td>
                </tr>
            </table>
            <p class="tagline">Fiche recette generee depuis votre espace culinaire</p>
        </div>

        <h1 class="recipe-title">{{ $recette->titre }}</h1>

        <div class="meta-box">
            <p class="meta"><strong>{{ __('messages.auteur') }}:</strong> {{ $recette->auteur }}</p>
            <p class="meta"><strong>{{ __('messages.categorie') }}:</strong> {{ $recette->categorie->nom_categorie ?? '-' }}</p>
            <p class="meta"><strong>{{ __('messages.temps') }}:</strong> {{ $recette->temps_preparation }} min</p>
        </div>

        @if($imageBase64)
            <div class="image-wrap">
                <img src="{{ $imageBase64 }}" alt="{{ $recette->titre }}">
            </div>
        @endif

        <div class="section">
            <h2>{{ __('messages.description') }}</h2>
            <p>{{ $recette->description }}</p>
        </div>

        <div class="section">
            <h2>{{ __('messages.ingredients') }}</h2>
            @if(count($ingredients) > 0)
                <ul>
                    @foreach($ingredients as $ingredient)
                        <li>{{ $ingredient }}</li>
                    @endforeach
                </ul>
            @else
                <p>{{ $recette->ingredients }}</p>
            @endif
        </div>

        <div class="section">
            <h2>{{ __('messages.etapes') }}</h2>
            @if($etapes->isNotEmpty())
                <ol>
                    @foreach($etapes as $etape)
                        <li>{{ $etape->description }}</li>
                    @endforeach
                </ol>
            @else
                <p>{{ __('messages.aucune_etape') }}</p>
            @endif
        </div>

        <p class="footer-note">
            {{ config('app.name', 'Coin des recettes') }} - Bon appetit
        </p>
    </div>
</body>
</html>
