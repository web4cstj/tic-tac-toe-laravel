<?php

use App\Http\Controllers\TicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tic/{joueur?}', [TicController::class, 'commencer'])->name('tic.commencer');
Route::get('/tic/{joueur}/{plateau}', [TicController::class, 'afficher'])
    ->name('tic.afficher')
    ->where(['joueur' => '[XO]', 'plateau' => '[XO-]{9}']);
Route::get('/tic/{joueur}/{plateau}/{position}', [TicController::class, 'jouer'])
    ->name('tic.jouer')
    ->where(['joueur' => '[XO]', 'position' => '[0-8]', 'plateau' => '[XO-]{9}']);
Route::get('/tic/{joueur}/gagnant', [TicController::class, 'gagnant'])
    ->name('tic.gagnant')
    ->where(['joueur' => '[XO]']);
