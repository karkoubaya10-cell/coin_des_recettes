<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recette;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiRecetteController extends Controller
{
    // API interne: liste des recettes en JSON.(tout les recettes en json)
    public function index()
    {
        $recettes = Recette::with(['categorie:id,nom_categorie', 'user:id,name'])
            ->latest() //du récent 
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recettes,
        ]);
    }

    // API interne: detail d'une recette en JSON.
    public function show($id)
    {
        $recette = Recette::with([
            'categorie:id,nom_categorie',
            'user:id,name',
            'commentaires.user:id,name',
            'etapes',
        ])->find($id);

        if (! $recette) {
            return response()->json([
                'success' => false,
                'message' => 'Recette introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $recette,
        ]);
    }

    // API externe consommee: TheMealDB (version simple).
    // Cette methode est reutilisable dans le projet web.
    // prend recette depuis api ext
    public function recupererInspirationCuisine(): ?array
    {
        try {
            // si api prend plus que 5s -> stop la requete
            $reponse = Http::timeout(5)->get('https://www.themealdb.com/api/json/v1/1/random.php');

            if (! $reponse->ok()) {
                return null;
            }

            $data = $reponse->json();// json -> table
            $meal = $data['meals'][0] ?? null;// retourne la 1ere recette

            if (! $meal) {
                return null;
            }

            return [
                'nom' => $meal['strMeal'] ?? null,
                'categorie' => $meal['strCategory'] ?? null,
                'origine' => $meal['strArea'] ?? null,
                'image' => $meal['strMealThumb'] ?? null,
            ];
        } catch (Throwable $e) { //log::warning écrit warning ds log de laravel
            Log::warning('Echec API externe inspiration cuisine', [
                'message' => $e->getMessage(),// msg d'erreur vrai pour le développeur 
            ]);

            return null; //pour l'application
        }
    }

    // Endpoint API simple pour verifier rapidement l'appel externe.
    // affiche api ext format json 
    public function inspirationCuisine()
    {
        $inspiration = $this->recupererInspirationCuisine();

        if (! $inspiration) {
            return response()->json([
                'success' => false,
                'message' => 'Inspiration indisponible.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data' => $inspiration,
        ]);
    }
}
