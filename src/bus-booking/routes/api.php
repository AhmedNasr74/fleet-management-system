<?php

use App\Http\Controllers\Users\Auth\LoginController;
use App\Http\Controllers\Users\Bus\BusController;
use App\Http\Controllers\Users\Trips\TripsController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::post('login', LoginController::class)->name('login');
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'trips', 'as' => 'trips.'], function () {
            Route::get('/', [TripsController::class, 'index'])->name('index');
            Route::get('/{trip}', [TripsController::class, 'show'])->name('show');
            Route::post('/show/available/seats', [TripsController::class, 'showAvailableSeats'])->name('show.available.seats');
            Route::post('/book/available/seat', [TripsController::class, 'bookSeat'])->name('book.available.seat');
        });


        Route::group(['prefix' => 'buses', 'as' => 'buses.'], function () {
            Route::get('/{bus}', [BusController::class, 'show'])->name('show');
        });

    });
});
