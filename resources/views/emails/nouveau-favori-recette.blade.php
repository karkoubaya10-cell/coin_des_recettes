<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau favori</title>
</head>
<body>
    <h2>Nouveau favori sur votre recette</h2>

    <p>
        <strong>{{ $nomUtilisateur }}</strong> a ajoute votre recette
        <strong>{{ $recette->titre }}</strong> en favori.
    </p>

    <p>
        Consulter la recette:
        <a href="{{ route('recettes.detail', $recette->id) }}">{{ route('recettes.detail', $recette->id) }}</a>
    </p>
</body>
</html>
