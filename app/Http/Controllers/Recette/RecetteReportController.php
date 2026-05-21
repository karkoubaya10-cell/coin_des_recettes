<?php

namespace App\Http\Controllers\Recette;

use App\Http\Controllers\Controller;
use App\Models\Recette;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecetteReportController extends Controller
{
    // Generation PDF recette.
    public function telechargerRecettePdf($id)
    {
        // 1) Chargement des données nécessaires à l'export PDF.
        $recette = Recette::with('categorie', 'etapes')->find($id);

        if (! $recette) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.recette_introuvable'));
        }

        // Vérification de dépendance système utilisée par la librairie PDF/images.
        // gd librairie php pour les photos aide pour traitement des img , géneration pdf ...=> car pdf contient image
        if (! extension_loaded('gd')) {
            return redirect()->route('recettes.detail', $recette->id)
                ->with('error', __('messages.gd_extension_manquante'));
        }

        // 2) Ingredients: conversion en liste ligne par ligne.
        $ingredients = preg_split('/\r\n|\r|\n/', (string) $recette->ingredients);
        $ingredients = array_values(array_filter(array_map('trim', $ingredients)));
        //split pour convertir en ligne par ligne
        //filter pour supp les elem vides 
        //array_value pour ordre 1.2.3

        // 3) Image en base64 pour inclusion directe dans le PDF/pour convertir fichier binary en texet pour le stocker ..
        // ce bloc prépare l'image pour la placer dans le pdf 
        $imageBase64 = null;
        if ($recette->image) {
            $cheminImage = storage_path('app/public/' . $recette->image);
            if (is_file($cheminImage)) {//si file exist vrai
                $typeMime = mime_content_type($cheminImage) ?: 'image/jpeg';//si on ne peut ps détecterou n'a ps de type par defait jpeg
                $imageBase64 = 'data:' . $typeMime . ';base64,' . base64_encode((string) file_get_contents($cheminImage));
                //exp : data:image/jpeg;base64,/9j/4AAQ... => pour utilisé directement ds pdf 
                //file_get_contents($cheminImage)=> lire le contenu du file 100101/base64..=>en texte/
            }
        }

        // Nom de fichier propre pour éviter les caractères invalides.
        $nomNettoye = preg_replace('/[^A-Za-z0-9_\-]/', '_', $recette->titre) ?: 'recette';//si le nom vide utilise 'recette'
        try {
            // 4) Génération puis téléchargement du PDF.
            $pdf = Pdf::loadView('recettes.pdf', [//blade->html->pdf
                'recette' => $recette,
                'ingredients' => $ingredients,
                'etapes' => $recette->etapes->sortBy('numero_etape'),
                'imageBase64' => $imageBase64,
            ]);

            return $pdf->download($nomNettoye . '.pdf');//téléchargement de pdf directement
        } catch (Throwable $e) {
            Log::error('Erreur generation PDF recette', [
                'recette_id' => $recette->id,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('recettes.detail', $recette->id)
                ->with('error', __('messages.pdf_indisponible_temporairement'));
        }
    }

    // Affichage stats depuis procedure stockee.
    public function statsProcedure()
    {
        $stats = DB::select('CALL sp_stats_recettes_par_categorie()');

        return view('recettes.stats-procedure')->with('stats', $stats);
    }

    // Affichage des 3 graphes demandes (histogramme / secteur / courbe).
    public function statsGraphes()//fct prépare data pour charts
    {
        // Graphe 1: recettes par categorie (procedure stockee).
        // Fallback SQLite: pas de procédure stockée, on reconstruit via query builder.
        if (DB::getDriverName() === 'sqlite') {//pour savoir type de DB si sqlLite => query manuellement comme suit
            $statsCategories = DB::table('categories as c')
                ->leftJoin('recettes as r', 'r.categorie_id', '=', 'c.id')//aussi qui ont pas de relation 
                ->selectRaw('c.nom_categorie, COUNT(r.id) as total_recettes')
                ->groupBy('c.id', 'c.nom_categorie')
                ->orderBy('c.nom_categorie')
                ->get();
        } else {
            //sql + array->collection
            $statsCategories = collect(DB::select('CALL sp_stats_recettes_par_categorie()'));
        }//=> [{nom_cat:"pizza",totale_recettes:10}]

        //pluck encoie juste seule colonne [{nom:"pizza",total:10},{nom:"dessert",total:7}] => ["pizza","dessert"]
        $labelsHistogramme = $statsCategories->pluck('nom_categorie')->values();//value pour ordre des indexes
        $valeursHistogramme = $statsCategories->pluck('total_recettes')->map(fn ($v) => (int) $v)->values();

        // Graphe 2 (secteur): nombre de recettes ajoutees par utilisateur.
        // leftJoin garde aussi les utilisateurs avec 0 recette.
        $statsUsers = DB::table('users as u')
            ->leftJoin('recettes as r', 'r.user_id', '=', 'u.id')
            ->selectRaw('u.name, COUNT(r.id) as total_recettes')
            ->groupBy('u.id', 'u.name')
            ->orderBy('u.name')
            ->get();

        $labelsSecteur = $statsUsers->pluck('name')->map(fn ($v) => $v ?: 'Utilisateur')->values();
        $valeursSecteur = $statsUsers->pluck('total_recettes')->map(fn ($v) => (int) $v)->values();

        // Graphe 3 (courbe): nouveaux utilisateurs inscrits par semaine.
        $inscriptions = DB::table('users')
            ->whereNotNull('created_at')//juste date
            ->orderBy('created_at')
            ->pluck('created_at');

        // Chaque date est ramenée au début de sa semaine, puis comptée.
        $groupesSemaines = $inscriptions
            ->map(function ($date) {
                //\Carbon\Carbon::parse($date)=>str->objet date / ->startOfWeek()=>envoie le 1er jour de la semaine
                $debutSemaine = \Carbon\Carbon::parse($date)->startOfWeek()->toDateString();
                return $debutSemaine;
            })
            ->countBy()//calcule répeté
            ->sortKeys();//ordre selon date

        $labelsCourbe = $groupesSemaines->keys()->values();//envoie label
        $valeursCourbe = $groupesSemaines->values()->map(fn ($v) => (int) $v)->values();//envoie résultat

        return view('recettes.graphes', [
            'labelsHistogramme' => $labelsHistogramme,
            'valeursHistogramme' => $valeursHistogramme,
            'labelsSecteur' => $labelsSecteur,
            'valeursSecteur' => $valeursSecteur,
            'labelsCourbe' => $labelsCourbe,
            'valeursCourbe' => $valeursCourbe,
        ]);
    }
}
