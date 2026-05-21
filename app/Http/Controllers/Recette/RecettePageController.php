<?php

namespace App\Http\Controllers\Recette;

use App\Http\Controllers\Api\ApiRecetteController;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Favori;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecettePageController extends Controller
{
    // Affichage liste recettes.
    public function listeRecettes(Request $r)
    {
        // Filtre optionnel par catégorie (si présent dans l'URL).
        $categorieChoisie = $r->categorie;//exp : cat : 3

        // si user ne choisue pas catégorie
        $recettes = Recette::select(
            'id',
            'auteur',
            'titre',
            'image',
            'user_id',
            'categorie_id'
        )->with('categorie');//chaque recette avec cat 

        if ($categorieChoisie) {
            $recettes->where('categorie_id', $categorieChoisie);
        }

        $categories = Categorie::all();

        return view('recettes.liste')
            ->with('recettes', $recettes->get())
            ->with('categories', $categories)
            ->with('categorieChoisie', $categorieChoisie);
    }

    // Affichage detail recette.
    public function detailRecette($id)
    {
        // Chargement complet de la recette pour la page détail.
        $recette = Recette::with('categorie', 'etapes', 'commentaires.user')->find($id);

        if (! $recette) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.recette_introuvable'));
        }

        // Tri d'affichage: étapes dans l'ordre, commentaires du plus récent au plus ancien.
        $recette->etapes = $recette->etapes->sortBy('numero_etape');//ordre selon les numeros 1.2.3
        $recette->commentaires = $recette->commentaires->sortByDesc('created_at');//récent vers ancien
        $nombreCommentaires = $recette->commentaires->count();
        $nombreFavoris = $recette->favoris()->count();

        $estFavori = false;
        if (Auth::check()) {//user connécté ?
            // L'état favori dépend du couple (user connecté, recette courante).
            $estFavori = Favori::where('user_id', Auth::id())//fvr de user connecté
                ->where('recette_id', $recette->id)//id de recette actuelle
                ->exists();//si user connecté fait favori a cette recette
        }

        // La logique de consommation API externe est deplacee dans ApiRecetteController.
        $inspirationCuisine = app(ApiRecetteController::class)->recupererInspirationCuisine();

        return view('recettes.detail')
            ->with('recette', $recette)
            ->with('estFavori', $estFavori)
            ->with('nombreCommentaires', $nombreCommentaires)
            ->with('nombreFavoris', $nombreFavoris)
            ->with('inspirationCuisine', $inspirationCuisine);
    }

    // Affichage des recettes de l'utilisateur connecte (admin inclus).
    public function mesRecettes()
    {
        $recettes = Recette::select(
            'id',
            'auteur',
            'titre',
            'image',
            'user_id',
            'categorie_id'
        )
            ->with('categorie')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('recettes.mes')
            ->with('recettes', $recettes);
    }
}
