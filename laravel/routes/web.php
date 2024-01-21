<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EpisodesController;


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

// Route::resource('articles', ArticleController::class, ['except' => ['show', 'edit', 'update']]);
Route::get('/episodes', [EpisodesController::class, 'adminIndex'])->name('episodes.adminIndex');
Route::get('/episodes/create', [EpisodesController::class, 'create'])->name('episodes.create');
Route::get('/episodes/{id}', [EpisodesController::class, 'show']);
Route::get('/episodes/{id}/edit', [EpisodesController::class, 'edit']);
Route::post('/episodes', [EpisodesController::class, 'update'])->name('episodes.update');


//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('logout', [LoginController::class, 'logout']);