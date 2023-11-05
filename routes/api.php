<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*

Route::post('inscriptionClient', [ClientController::class, 'inscription']);
Route::post('validerClient', [ClientController::class, 'Validerinfo']);
Route::post('connexion', [ClientController::class, 'Connexion']);
Route::get('recupeClient/{id}', [ClientController::class, 'EnvoiClient']);
Route::post('demandeService/{idclient}/{idservice}', [ClientController::class, 'DemandeService']);
Route::post('envoiSuggestion/{id}', [ClientController::class, 'EnvoiSuggestion']);
Route::post('modifiernom/{id}', [ClientController::class, 'modifierNom']);
Route::post('modifiermdp/{id}', [ClientController::class, 'modifierMDP']);
Route::get('demandesEnvoyer/{id}', [ClientController::class, 'DemandeEnvoyer']);

Route::post('AllService', [AllController::class, 'AllService']);

Route::post('inscriptionAdmin', [AdminController::class, 'InscriptionAdmin']);
Route::post('connexionAdmin', [AdminController::class, 'ConnexionAdmin']);
Route::post('ajouterService', [AdminController::class, 'AjouterServices']);
Route::post('modifierAdminNom/{id}', [AdminController::class, 'modifierNom']);
Route::post('modifierAdminmdp/{id}', [AdminController::class, 'modifierMDP']);
Route::post('supprimerService/{id}', [AdminController::class, 'SuprimerService']);

*/