<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau commentaire</title>
</head>
<body>
    <h2>Nouveau commentaire sur votre recette</h2>

    <p>
        Bonjour, votre recette <strong>{{ $recette->titre }}</strong> a recu un nouveau commentaire.
    </p>

    <p>
        <strong>Auteur du commentaire:</strong> {{ $nomCommentateur }}
    </p>

    <p>
        <strong>Contenu:</strong><br>
        {{ $commentaire->contenu }}
    </p>

    <p>
        Vous pouvez consulter la recette ici:
        <a href="{{ route('recettes.detail', $recette->id) }}">{{ route('recettes.detail', $recette->id) }}</a>
    </p>
</body>
</html>
