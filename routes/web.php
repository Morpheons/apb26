<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AproposController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjetController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------
| Route du site
|----------------------------------------------
*/
Route::get('/',                                       [AccueilController::class, 'accueil'])                        -> name('accueil');
Route::get('/apropos',                                [AproposController::class, 'showFamilles'])                   -> name('apropos');
Route::get('/contact',                                [ContactController::class, 'showFamilles'])                   -> name('contact');
Route::post('/contact',                               [ContactController::class, 'generateMessage'])                -> name('envoimessage');
Route::get  ('/famille/{slug}.html',                  [AccueilController::class, 'showFamilles'])                   ->name('details_famille');
Route::get  ('/projet/{slug}.html',                   [ProjetController::class, 'showProjet'])                      ->name('details_projet');

Route::get    ('/deconnexion', function (){
    Auth::logout();
    return redirect()->route('accueil');
})->name('app.logout');
