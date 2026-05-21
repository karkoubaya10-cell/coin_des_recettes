<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Recette\RecetteCrudController;
use App\Http\Controllers\Recette\RecetteInteractionController;
use App\Http\Controllers\Recette\RecettePageController;
use App\Http\Controllers\Recette\RecetteReportController;
use App\Http\Controllers\Recette\RecetteArchiveController;
use App\Http\Controllers\Xml\XmlController;
use Illuminate\Support\Facades\Session;

// الصفحة الرئيسية
Route::get('/', function () {
    return redirect()->route('recettes.liste');
});

// dashboard (ديال breeze)
// profile (ديال breeze)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('recettes.liste');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //  هنا نحطو routes ديالك لي خاصهم login
    Route::get('/recettes/ajouter', [RecetteCrudController::class, 'formulaireAjout'])->name('recettes.ajouter.form');
    Route::post('/recettes/ajouter', [RecetteCrudController::class, 'ajouterRecette'])->name('recettes.ajouter');

    Route::get('/recettes/modifier/{id}', [RecetteCrudController::class, 'formulaireModification'])->name('recettes.modifier.form');
    Route::post('/recettes/modifier', [RecetteCrudController::class, 'modifierRecette'])->name('recettes.modifier');
    Route::post('/recettes/{id}/supprimer', [RecetteCrudController::class, 'supprimerRecette'])->name('recettes.supprimer');
    Route::post('/recettes/{id}/commentaires', [RecetteInteractionController::class, 'ajouterCommentaire'])->name('commentaires.ajouter');
    Route::post('/commentaires/{id}/supprimer', [RecetteInteractionController::class, 'supprimerCommentaire'])
        ->name('commentaires.supprimer');
    Route::post('/recettes/{id}/favori', [RecetteInteractionController::class, 'toggleFavori'])->name('favoris.toggle');
    Route::get('/recettes/{id}/pdf', [RecetteReportController::class, 'telechargerRecettePdf'])
        ->name('recettes.pdf');
    Route::get('/mes-favoris', [RecetteInteractionController::class, 'mesFavoris'])->name('favoris.liste');
    Route::get('/mes-recettes', [RecettePageController::class, 'mesRecettes'])->name('recettes.mes');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/stats/procedure', [RecetteReportController::class, 'statsProcedure'])->name('stats.procedure');
    Route::get('/stats/graphes', [RecetteReportController::class, 'statsGraphes'])->name('stats.graphes');
    Route::get('/archives', [RecetteArchiveController::class, 'index'])->name('archives.index');
    Route::delete('/archives/{id}', [RecetteArchiveController::class, 'destroy'])->name('archives.destroy');
    Route::post('/archives/clear', [RecetteArchiveController::class, 'clear'])->name('archives.clear');

    // XML reserve uniquement a l'admin.
    Route::get('/xml', [XmlController::class, 'index'])->name('xml.index');
    Route::get('/xml/export', [XmlController::class, 'export'])->name('xml.export');
    Route::post('/xml/import', [XmlController::class, 'import'])->name('xml.import');
    Route::get('/admin/favoris', [RecetteInteractionController::class, 'listeFavorisAdmin'])->name('favoris.admin');
});

//  routes عاديين (ماشي ضروري login)
Route::get('/recettes',[RecettePageController::class,'listeRecettes'])->name('recettes.liste');
Route::get('/recettes/{id}', [RecettePageController::class, 'detailRecette'])->name('recettes.detail');

//Route pour que user peut changer la langue 
//{locale}=> variable dynamique fr ou en
Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['fr', 'en'])) {//vérification si langue exist ou non 
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();
});
// مهم ديال auth
require __DIR__.'/auth.php';
