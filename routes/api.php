<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TMDBController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/version', function(Request $request){
    return response()->json(['version' => '1.0.0']);
})->name('version');

Route::get('/get-movie/{id}', [TMDBController::class, 'getMovie'])->name('version');
Route::get('/test/{id}', [TMDBController::class, 'getLogo'])->name('test');

