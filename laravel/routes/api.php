<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\PodcastsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function () {
    return response()->json(['name' => 'Abigail', 'state' => 'CA']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/account', [AuthController::class, 'getAccount'])->middleware('auth:sanctum');
Route::apiResource('episodes', EpisodesController::class);
Route::apiResource('podcasts', PodcastsController::class);
Route::apiResource('tags', TagsController::class);
Route::get('plays', [EpisodesController::class, 'getPlays']);
Route::get('plays/{userId}', [EpisodesController::class, 'getUserPlays']);
Route::post('plays', [EpisodesController::class, 'addEpisodePlay'])->middleware('auth:sanctum');
//Route::post('episodes/json-create', [EpisodesController::class, 'storeEpisodeFromJson'])->middleware('auth:sanctum'); temporarily commented because no internet when deved
Route::post('episodes/json-create', [EpisodesController::class, 'storeEpisodeFromJson']);

Route::fallback(function () {
    return response()->json(['message' => 'Route not found'], 404);
});





// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::resource('podcasts', PodcastsController::class, ['only' => ['index', 'store']]);