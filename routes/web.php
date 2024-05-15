<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchTripController;
use App\Http\Controllers\BuildTripController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/search', [SearchTripController::class, 'index'])->name('index');

Route::get('/trips', [BuildTripController::class, 'index'])->name('index');

Route::post('/createTrip', [BuildTripController::class, 'createTrip'])->name('createTrip');

Route::get('/searchFlights', [BuildTripController::class, 'searchFlights'])->name('searchFlights');

Route::post('/search', [SearchTripController::class, 'search'])->name('search');

Route::get('/getTripInfo', [BuildTripController::class, 'getTripDataBeforeCreation'])->name('getTripInfo');
