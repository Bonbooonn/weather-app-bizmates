<?php

use App\Http\Controllers\Api\Auth\AuthenticateUserController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\PlacesController;
use App\Http\Controllers\Api\WeatherController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('places', [PlacesController::class, 'getPlaces']);
    Route::get('saved-places-weather', [WeatherController::class, 'getSavedPlacesWeather']);
    Route::get('validate-token', function () {
        return response()->json(['message' => 'Valid token', 'user' => auth()->user()], 200);
    });

    Route::post('weather', [WeatherController::class, 'getWeather']);
    Route::post('logout', function (Request $request) {
        auth()->guard('web')->logout();
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    });

    Route::delete('{userSavedPlace}/remove-saved-place', [WeatherController::class, 'deleteSavedPlace']);
});

Route::post('login', AuthenticateUserController::class);
Route::post('register', RegisterController::class);
