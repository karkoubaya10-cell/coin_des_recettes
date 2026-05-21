<?php

use App\Http\Controllers\Api\ApiRecetteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (lecture simple)
|--------------------------------------------------------------------------
| On garde seulement l'affichage des recettes en JSON.
*/
Route::get('/recettes', [ApiRecetteController::class, 'index']);
Route::get('/recettes/{id}', [ApiRecetteController::class, 'show']);
Route::get('/inspiration-cuisine', [ApiRecetteController::class, 'inspirationCuisine']);
