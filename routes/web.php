<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\SalarierController;

Route::get('/', function () {
    return view('/');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [SalarierController::class, 'index']);
    //Salarier
    Route::resource('salarier', SalarierController::class);

    //Pointage
    Route::resource('pointage', PointageController::class);
    Route::get('/accueil', [PointageController::class, 'accueil']);
    Route::get('pointage/show/{salarierId}', [PointageController::class, 'show'])->name('pointage.show');
    Route::get('/liste_pointage', [PointageController::class, 'listePointage']);
    Route::patch('update/updateAll', [UpdateController::class, 'updateAll'])->name('update.updateAll');
});

Auth::routes();