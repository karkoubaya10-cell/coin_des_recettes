<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
</head>
<body>
    <h2>Bienvenue {{ $user->name }}</h2>

    <p>
        Merci de vous etre inscrit sur <strong>Plateforme Recettes</strong>.
    </p>

    <p>
        Vous pouvez maintenant ajouter vos recettes, les partager et gerer vos favoris.
    </p>

    <p>
        Acceder au site:
        <a href="{{ route('recettes.liste') }}">{{ route('recettes.liste') }}</a>
    </p>
</body>
</html>
