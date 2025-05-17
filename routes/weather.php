<?php

use App\Http\Controllers\Weather\WeatherContoller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('weather/current', [WeatherContoller::class, 'current']);
    Route::get('weather/history', [WeatherContoller::class, 'history']);
    Route::post('weather/favorite', [WeatherContoller::class, 'addFavorite']);
    Route::get('weather/favorites', [WeatherContoller::class, 'favorites']);
});