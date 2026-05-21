<?php

namespace App\Http\Controllers\Xml;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class XmlController extends Controller
{
    /**
     * Affiche une page simple pour exporter/importer le XML.
     */
    public function index()
    {
        return view('xml.index');
    }

    /**
     * Exporte les recettes dans un fichier XML.
     */
    public function export()
    {
        // On récupère uniquement les colonnes utiles pour le fichier XML.
        $recettes = Recette::select(
            'id',
            'auteur',
            'titre',
            'description',
            'ingredients',
            'temps_preparation',
            'categorie_id'
        )->with('etapes')->get();

        //\SimpleXMLElement => class f php pour créer xml 
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><recettes></recettes>');

        foreach ($recettes as $recette) {
            // Chaque recette devient un noeud <recette> dans <recettes>.
            // htmlspecialchars => pour protéger xml du caractère comme &
            // xml prend que string
            $node = $xml->addChild('recette');//+<recette></recette>
            $node->addChild('auteur', htmlspecialchars((string) $recette->auteur));//+<auteur>...</auteur>
            $node->addChild('titre', htmlspecialchars((string) $recette->titre));
            $node->addChild('description', htmlspecialchars((string) $recette->description));
            $node->addChild('ingredients', htmlspecialchars((string) $recette->ingredients));
            $node->addChild('temps_preparation', (string) $recette->temps_preparation);
            $node->addChild('categorie_id', (string) $recette->categorie_id);

            // Export des étapes (si disponibles).
            $etapesNode = $node->addChild('etapes');
            foreach ($recette->etapes->sortBy('numero_etape') as $etape) {
                $etapeNode = $etapesNode->addChild('etape', htmlspecialchars((string) $etape->description));
                $etapeNode->addAttribute('numero', (string) $etape->numero_etape);//+ <etape numero="1">
            }
        }

        $contenu = $xml->asXML();//convertir xml en texte

        return response($contenu, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',//déclare navigateir que c'est un fichier xml 
            'Content-Disposition' => 'attachment; filename="recettes.xml"',//force nvgt télécharger fichier
        ]);
    }

    /**
     * Importe les recettes depuis un fichier XML.
     * Validation simple + lisible.
     */
    public function import(Request $request)
    {
        // 1) Validation du fichier importe.
        $request->validate([
            'xml_file' => ['required', 'file', 'mimes:xml,txt', 'max:2048'],
        ], [
            'xml_file.required' => __('validation.custom.xml_file.required'),
            'xml_file.file' => __('validation.custom.xml_file.file'),
            'xml_file.mimes' => __('validation.custom.xml_file.mimes'),
            'xml_file.max' => __('validation.custom.xml_file.max'),
        ]);

        $path = $request->file('xml_file')->getRealPath();

        // 2) Lecture du XML avec gestion d'erreurs de parsing.
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($path);//lire xml ->object

        if ($xml === false) {
            return redirect()->route('xml.index')
                ->with('error', 'Le fichier XML est invalide.');
        }

        $totalLues = 0;
        $totalImportees = 0;
        $totalIgnoreesIncompletes = 0;
        $totalIgnoreesSansCategorie = 0;
        $totalIgnoreesDoublons = 0;

        // 3) Import ligne par ligne:
        //    - nettoyage
        //    - contrôles (champs/catégorie/doublon)
        //    - insertion
        foreach ($xml->recette as $item) {
            $totalLues++;

            $auteur = trim((string) ($item->auteur ?? ''));
            $titre = trim((string) ($item->titre ?? ''));
            $description = trim((string) ($item->description ?? ''));
            $ingredients = trim((string) ($item->ingredients ?? ''));
            $temps = (int) ($item->temps_preparation ?? 0);
            $categorieId = (int) ($item->categorie_id ?? 0);
            $etapes = [];

            if (isset($item->etapes->etape)) {//isset => si exist car peut etre des recette pas d'etape
                foreach ($item->etapes->etape as $etapeItem) {
                    $etapes[] = trim((string) $etapeItem);
                }
            }

            // Nettoyage: on retire les étapes vides.
            $etapes = array_values(array_filter($etapes, fn ($v) => $v !== ''));

            // Validation proche d'ajout/modification 
            //validation manuelle car ds la boucle chaque recette est traité seule 
            $validation = Validator::make([
                'auteur' => $auteur,
                'titre' => $titre,
                'description' => $description,
                'ingredients' => $ingredients,
                'temps_preparation' => $temps,
                'etapes' => $etapes,
            ], [
                'auteur' => ['bail', 'required', 'string', 'min:3', 'max:100', 'regex:/^[\pL\s\'-]+$/u'],
                'titre' => ['bail', 'required', 'string', 'min:3', 'max:100', 'regex:/.*\S.*/'],
                'description' => ['bail', 'required', 'string', 'min:10', 'max:5000', 'regex:/.*\S.*/'],
                'ingredients' => ['bail', 'required', 'string', 'min:5', 'max:5000', 'regex:/.*\S.*/'],
                'temps_preparation' => ['bail', 'required', 'integer', 'min:1', 'max:1440'],
                'etapes' => ['required', 'array', 'min:1'],
                'etapes.*' => ['required', 'string', 'min:3', 'max:1000', 'regex:/.*\S.*/'],
            ]);

            //si recette invalid => ignore + continue 
            if ($validation->fails()) {
                $totalIgnoreesIncompletes++;
                continue;
            }

            // Si categorie absente/invalide, on prend la 1re categorie existante.
            if (! Categorie::where('id', $categorieId)->exists()) {
                $categorieId = (int) (Categorie::query()->value('id') ?? 0);
            }

            if ($categorieId === 0) {
                // Pas de categorie en base -> on ne peut pas importer cette recette.
                $totalIgnoreesSansCategorie++;
                continue;
            }

            // Eviter les doublons simples (titre + auteur).
            $existe = Recette::where('titre', $titre)
                ->where('auteur', $auteur)
                ->exists();

            if ($existe) {
                $totalIgnoreesDoublons++;
                continue;
            }

            // Insertion de la recette importée: l'utilisateur courant devient propriétaire.
            $recette = new Recette();
            $recette->auteur = $auteur;
            $recette->titre = $titre;
            $recette->description = $description;
            $recette->ingredients = $ingredients;
            $recette->temps_preparation = $temps;
            $recette->categorie_id = $categorieId;
            $recette->user_id = Auth::id();
            $recette->save();

            foreach ($etapes as $index => $descriptionEtape) {
                $recette->etapes()->create([
                    'numero_etape' => $index + 1,
                    'description' => $descriptionEtape,
                ]);
            }

            $totalImportees++;
        }

        $message = $totalImportees . ' recette(s) importee(s). '
            . $totalIgnoreesDoublons . ' doublon(s) ignore(s). '
            . $totalIgnoreesIncompletes . ' ligne(s) incomplete(s) ignoree(s). '
            . $totalIgnoreesSansCategorie . ' ligne(s) sans categorie valide ignoree(s). '
            . 'Total lu: ' . $totalLues . '.';

        return redirect()->route('xml.index')->with('success', $message);
    }
}
