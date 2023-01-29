<?php

use App\Http\Controllers\GiftsController;
use App\Http\Controllers\LookupController;
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
    return view('pages/home');
});
Route::get('/lookup', [LookupController::class, 'index']);
Route::post('/lookup', [LookupController::class, 'lookup']);
Route::get('/gifts', [GiftsController::class, 'index']);
Route::get('/gifts/randomize', [GiftsController::class, 'randomize']);
