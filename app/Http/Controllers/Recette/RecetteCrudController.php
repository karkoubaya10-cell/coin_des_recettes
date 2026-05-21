<?php

namespace App\Http\Controllers\Recette;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecetteCrudController extends Controller
{
    // Regles de validation de la recette. privé juste pour ce controller 
    private function reglesValidationRecette(): array
    {
        return [
            'auteur' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:100',
                // Lettres + espaces + apostrophes + tirets (ex: Jean-Pierre, O'Neil).
                'regex:/^[\pL\s\'-]+$/u',
            ],// bail : si 1er validation echoue stop le reste 
            'titre' => ['bail', 'required', 'string', 'min:3', 'max:100', 'regex:/.*\S.*/'],
            'description' => ['bail', 'required', 'string', 'min:10', 'max:5000', 'regex:/.*\S.*/'],
            'ingredients' => ['bail', 'required', 'string', 'min:5', 'max:5000', 'regex:/.*\S.*/'],
            'temps_preparation' => ['bail', 'required', 'integer', 'min:1', 'max:1440'],//1440=24h
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],//2 MB
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'etapes' => ['required', 'array', 'min:1'],// etape en globale 
            'etapes.*' => ['required', 'string', 'min:3', 'max:1000', 'regex:/.*\S.*/'],// chaque élem ou etape dans etapes 
        ];
    }

    // Messages ciblés pour les règles renforcées.
    private function messagesValidationRecette(): array
    {
        return [
            'auteur.regex' => __('validation.custom.auteur.regex'),
            'titre.regex' => __('validation.custom.titre.regex'),
            'description.regex' => __('validation.custom.description.regex'),
            'ingredients.regex' => __('validation.custom.ingredients.regex'),
            'etapes.*.regex' => __('validation.custom.etapes.regex'),
            'temps_preparation.max' => __('validation.custom.temps_preparation.max'),
        ];
    }

    // Noms plus lisibles pour les messages d'erreur. à la place de categorie_id oblg => categorie oblg 
    private function attributsValidationRecette(): array
    {
        return [
            'auteur' => __('messages.auteur'),
            'titre' => __('messages.titre_col'),
            'description' => __('messages.description'),
            'ingredients' => __('messages.ingredients'),
            'temps_preparation' => __('messages.temps'),
            'image' => __('messages.image'),
            'categorie_id' => __('messages.categorie'),
            'etapes' => __('messages.etapes'),
            'etapes.*' => __('messages.etape'),
        ];
    }

    // On retire les etapes vides avant enregistrement.
    private function nettoyerEtapes(array $etapes): array
    {
        return collect($etapes) //fn abrévéation de fct 
            ->map(fn ($etape) => trim((string) $etape)) // trim : " cuire " => "cuire"
            ->filter() // supp les val vides 
            ->values() //reorganise l'ordre des indexes 
            ->all(); // retourne array 
    }

    public function formulaireAjout()
    {
        $categories = Categorie::all();

        return view('recettes.ajouter')->with('categories', $categories);
    }

    public function ajouterRecette(Request $r)
    {
        $r->merge([ //pour remplacer les nciens valuers par les nouveaux 
            'etapes' => $this->nettoyerEtapes($r->input('etapes', [])),//[] valeur par défaut 
        ]);

        $r->validate(
            $this->reglesValidationRecette(), // les regles 
            $this->messagesValidationRecette(), //les msg 
            $this->attributsValidationRecette() //les noms des champs 
        );

        $etapes = $r->input('etapes', []); //place etapes ds le variable $etapes

        //transaction : care l'opération est divisée en deux recette et etapes => les deux doit enregistrer avec succée 
        DB::transaction(function () use ($r, $etapes) {// tout ou rien 
            $recette = new Recette();
            $recette->auteur = $r->auteur;
            $recette->titre = $r->titre;
            $recette->description = $r->description;
            $recette->ingredients = $r->ingredients;
            $recette->temps_preparation = $r->temps_preparation;

            if ($r->hasFile('image')) {
                $recette->image = $r->file('image')->store('images', 'public');
            }

            $recette->user_id = Auth::id();//récuperer id de user connecté
            $recette->categorie_id = $r->categorie_id;
            $recette->save();

            foreach ($etapes as $index => $description) {
                $recette->etapes()->create([ //création d'une étape liée à la recette 
                    'numero_etape' => $index + 1,
                    'description' => $description,
                ]);
            }
        });

        return redirect()->route('recettes.liste')
            ->with('success', __('messages.recette_ajoutee'));
    }

    public function formulaireModification($id)
    {
        $recette = Recette::with('etapes')->find($id);
        if (! $recette) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.recette_introuvable'));
        }

        $categories = Categorie::all();

        return view('recettes.modifier')
            ->with('recette', $recette)
            ->with('categories', $categories);
    }

    public function modifierRecette(Request $r)
    {
        $recette = Recette::with('etapes')->find($r->id);

        if (! $recette) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.recette_introuvable'));
        }

        if (Auth::user()->role !== 'admin' && Auth::id() !== $recette->user_id) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.acces_refuse_modification'));
        }

        $r->merge([
            'etapes' => $this->nettoyerEtapes($r->input('etapes', [])),
        ]);

        $r->validate(
            $this->reglesValidationRecette(),
            $this->messagesValidationRecette(),
            $this->attributsValidationRecette()
        );

        $etapes = $r->input('etapes', []);

        DB::transaction(function () use ($r, $recette, $etapes) {
            $recette->auteur = $r->auteur;
            $recette->titre = $r->titre;
            $recette->description = $r->description;
            $recette->ingredients = $r->ingredients;
            $recette->temps_preparation = $r->temps_preparation;

            if ($r->hasFile('image')) {
                $recette->image = $r->file('image')->store('images', 'public');
            }

            $recette->categorie_id = $r->categorie_id;
            $recette->save();

            $recette->etapes()->delete();//supprime touts les étapes puis les récreer même si il na chanage rien 

            foreach ($etapes as $index => $description) {
                $recette->etapes()->create([
                    'numero_etape' => $index + 1,
                    'description' => $description,
                ]);
            }
        });

        return redirect()->route('recettes.detail', $recette->id)
            ->with('success', __('messages.recette_modifiee'));
    }

    public function supprimerRecette($id)
    {
        $recette = Recette::find($id);

        if (! $recette) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.recette_introuvable'));
        }

        if (Auth::user()->role !== 'admin' && Auth::id() !== $recette->user_id) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.acces_refuse_suppression'));
        }

        DB::transaction(function () use ($recette) {
            $recette->delete();
        });

        return redirect()->route('recettes.liste')
            ->with('success', __('messages.recette_supprimee'));
    }
}
