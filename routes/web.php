<?php

use Illuminate\Support\Facades\Route;
// Chemin des contrôleurs
use App\Http\Controllers\connexionController;
use App\Http\Controllers\etatFraisController;
use App\Http\Controllers\gererFraisController;
use App\Http\Controllers\ComptableController;

// Création des groupes de routes
Route::controller(connexionController::class)->group(function () {
    Route::get('/', 'connecter')->name('chemin_connexion');
    Route::post('/', 'valider')->name('chemin_valider');
    Route::get('/deconnexion', 'deconnecter')->name('chemin_deconnexion');
});

Route::controller(etatFraisController::class)->group(function () {
    Route::get('/selectionMois', 'selectionnerMois')->name('chemin_selectionMois');
    Route::post('/listeFrais', 'voirFrais')->name('chemin_listeFrais');
});

Route::controller(gererFraisController::class)->group(function () {
    Route::get('/gererFrais', 'saisirFrais')->name('chemin_gestionFrais');
    Route::post('/sauvegarderFrais', 'sauvegarderFrais')->name('chemin_sauvegardeFrais');
});

Route::controller(ComptableController::class)->group(function () {
    Route::get('/comptable/selection', 'selection')->name('chemin_comptable_selection');
    Route::post('/comptable/selection', 'chargerMois')->name('chemin_comptable_chargermois');
    Route::post('/comptable/fiche', 'voirFiche')->name('chemin_comptable_fiche');
    Route::post('/comptable/valider', 'validerFiche')->name('chemin_comptable_valider');
    Route::get('/comptable/etat-quotidien', 'genererEtatQuotidien')->name('chemin_etat_quotidien');
    Route::post('/comptable/etat-quotidien', 'telechargerEtat')->name('chemin_etat_quotidien_dl');
    Route::get('/comptable/validees-aujourdhui.pdf', 'exporterValideesAujourdhui')->name('chemin_validees_aujourdhui_pdf');
});

?>