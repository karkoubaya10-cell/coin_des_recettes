<?php

namespace App\Http\Controllers\Recette;

use App\Http\Controllers\Controller;
use App\Mail\NouveauCommentaireRecetteMail;
use App\Mail\NouveauFavoriRecetteMail;
use App\Models\Commentaire;
use App\Models\Favori;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class RecetteInteractionController extends Controller
{
    public function mesFavoris()
    {
        // Liste des favoris de l'utilisateur connecté (admin inclus).
        $favoris = Favori::with('recette.categorie')
            ->where('user_id', Auth::id())
            ->get();

        return view('recettes.favoris')
            ->with('favoris', $favoris)
            ->with('modeAdminListe', false);// pour travailler avec même view ms avec comportement de variable
    }

    public function listeFavorisAdmin()
    {
        // Vue admin: on groupe les favoris par recette pour afficher qui a liké quoi.
        $favorisParRecette = Favori::with(['recette.categorie', 'recette.user', 'user']) // user de la recette + user qui fait favori 
            ->get()
            ->filter(fn ($favori) => $favori->recette !== null)// supp les favoris des recettes supprimées 
            ->groupBy('recette_id'); // groupe par recette 

        return view('recettes.favoris')
            ->with('favorisParRecette', $favorisParRecette)
            ->with('modeAdminListe', true);
    }

    public function ajouterCommentaire(Request $r, $id)
    {
        // 1) Récupération de la recette cible.
        $recette = Recette::with('user')->find($id); // recette avec owner 

        if (! $recette) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.recette_introuvable'));
        }

        // 2) Nettoyage rapide pour bloquer un commentaire vide (espaces seulement).
        $contenu = trim($r->contenu);
        if ($contenu === '') {
            return redirect()->route('recettes.detail', $recette->id)
                ->withErrors(['contenu' => __('messages.commentaire_vide')])
                ->withInput();//conserve les donées entrées 
        }

        // 3) Validation Laravel standard (messages personnalisés).
        $r->merge(['contenu' => $contenu]);
        $r->validate([
            'contenu' => ['required', 'min:2'],
        ], [
            'contenu.required' => __('validation.custom.contenu.required'),
            'contenu.min' => __('validation.custom.contenu.min'),
        ], [
            'contenu' => __('messages.commentaire'),
        ]);

        // 4) Enregistrement du commentaire.
        $commentaire = new Commentaire();
        $commentaire->contenu = $r->contenu;
        $commentaire->date_commentaire = now()->toDateString();//pour supp l'heure.min.sec 
        $commentaire->user_id = Auth::id();
        $commentaire->recette_id = $recette->id;
        $commentaire->save();

        // 5) Notification email au propriétaire (sauf auto-commentaire).
        // recette a owner + owner a email + user de la recette != email connecté
        if ($recette->user && $recette->user->email && $recette->user_id !== Auth::id()) {
            try {
                Mail::to($recette->user->email)->send(
                    new NouveauCommentaireRecetteMail($recette, $commentaire, (string) Auth::user()->name)
                );
            } catch (Throwable $e) {// $e prend ls infos incorrects 
                Log::warning('Erreur envoi email commentaire recette', [
                    'recette_id' => $recette->id,//recette qui a probleme
                    'commentaire_id' => $commentaire->id,//quelle comment
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('recettes.detail', $recette->id)
            ->with('success', __('messages.commentaire_ajoute'));//__():fct de traduction
    }

    public function supprimerCommentaire($id)
    {
        $commentaire = Commentaire::find($id);

        if (! $commentaire) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.commentaire_introuvable'));
        }

        // Sécurité: seul l'admin ou l'auteur du commentaire peut supprimer.
        if (Auth::user()->role !== 'admin' && Auth::id() !== $commentaire->user_id) {
            return redirect()->route('recettes.detail', $commentaire->recette_id)
                ->with('error', __('messages.acces_refuse_commentaire'));
        }

        $recetteId = $commentaire->recette_id;
        $commentaire->delete();

        return redirect()->route('recettes.detail', $recetteId)
            ->with('success', __('messages.commentaire_supprime'));
    }

    public function toggleFavori($id)
    {
        // Principe "toggle":
        // - si favori existe déjà => suppression
        // - sinon => création
        $recette = Recette::with('user')->find($id);//recette + owner

        if (! $recette) {
            return redirect()->route('recettes.liste')
                ->with('error', __('messages.recette_introuvable'));
        }

        //favori de user connécté pour cette recette 
        $favori = Favori::where('user_id', Auth::id())// id de user connécte = user qui a fait favori 
            ->where('recette_id', $recette->id)//pour cette recette 
            ->first();

        if ($favori) {
            // Cas 1: l'utilisateur retire son favori.
            $favori->delete();

            return redirect()->route('recettes.detail', $recette->id)
                ->with('success', __('messages.favori_supprime'));
        }

        // Cas 2: l'utilisateur ajoute la recette en favori.
        $favori = new Favori();
        $favori->date_ajout = now()->toDateString();
        $favori->user_id = Auth::id();
        $favori->recette_id = $recette->id;
        $favori->save();

        // Email au propriétaire (sauf si l'auteur se met lui-même en favori).
        if ($recette->user && $recette->user->email && $recette->user_id !== Auth::id()) {
            try {
                Mail::to($recette->user->email)->send(
                    new NouveauFavoriRecetteMail($recette, (string) Auth::user()->name)
                );
            } catch (Throwable $e) {
                Log::warning('Erreur envoi email favori recette', [
                    'recette_id' => $recette->id,
                    'favori_user_id' => Auth::id(),
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('recettes.detail', $recette->id)
            ->with('success', __('messages.favori_ajoute'));
    }
}
