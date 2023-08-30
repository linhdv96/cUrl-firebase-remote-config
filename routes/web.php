<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\TestController::class, 'get_token']);
Route::get('/firebase_remote_config', [\App\Http\Controllers\TestController::class, 'firebase_remote_config']);


Route::get('/listGame', [\App\Http\Controllers\GameController::class, 'listGame']);
Route::post('/change_cf_game_promo', [\App\Http\Controllers\GameController::class, 'change_cf_game_promo'])->name('game.change_cf_game_promo');
