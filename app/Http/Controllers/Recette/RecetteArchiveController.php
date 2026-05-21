<?php

namespace App\Http\Controllers\Recette;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RecetteArchiveController extends Controller
{
    // Affichage des recettes archivees pour l'admin.
    public function index()
    {
        $archives = DB::table('recettes_archive as ra')
            ->leftJoin('categories as c', 'c.id', '=', 'ra.categorie_id')//liaison entre archive et sa categorie et left pour que si cat supprimé archive reste affichée
            ->select('ra.*', 'c.nom_categorie')
            ->orderByDesc('date_archivage') //vers l'ancien 
            ->orderByDesc('ra.id')
            ->get();

        return view('recettes.archives', [
            'archives' => $archives,//envoie variable $archv avec le nom archive vers view
        ]);
    }

    // Suppression d'une seule ligne d'archive.
    public function destroy(int $id)
    {
        $supprime = DB::table('recettes_archive')->where('id', $id)->delete();
    // __() : c'est fct de laravel pour la traduction 
        if (! $supprime) {
            return redirect()->route('archives.index')
                ->with('error', __('messages.archive_introuvable'));// du fichier message prend la valeur de la clé archive_introuvable 
        }

        return redirect()->route('archives.index')
            ->with('success', __('messages.archive_supprimee'));
    }

    // Vidage complet de la table d'archive.
    public function clear()
    {
        DB::table('recettes_archive')->truncate();

        return redirect()->route('archives.index')
            ->with('success', __('messages.archives_vides'));
    }
}
