<?php

use App\Http\Middleware\SessionIsValid;
use App\Http\Middleware\CheckOrder;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HallsController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\SeatTypesController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\FilmSessionsController;
use App\Http\Controllers\OrdersController;

Route::get('/', function () {
    return view('client/index');
});

Route::get('/client/films', [FilmsController::class, 'index']);
Route::get('/client/films/{id}', [FilmsController::class, 'show']);

Route::get('/client/halls/{id}', [HallsController::class, 'show']);

Route::get('/client/places', [PlacesController::class, 'index']);

Route::get('/client/types', [SeatTypesController::class, 'index']);

Route::get('/client/orders', [OrdersController::class, 'index']);
Route::post('/client/orders', [OrdersController::class, 'store'])->middleware(CheckOrder::class);

Route::group(['middleware' => 'auth'], static function () {
    Route::get('/admin', static function () {
        return view('admin/index');
    });

    Route::get('/admin/halls', [HallsController::class, 'index']);
    Route::post('/admin/halls', [HallsController::class, 'store']);
    Route::delete('/admin/halls/{id}', [HallsController::class, 'destroy']);

    Route::get('/admin/hall/{id}', [HallsController::class, 'show']);
    Route::put('/admin/hall/{id}', [HallsController::class, 'update']);

    Route::get('/admin/places', [PlacesController::class, 'index']);
    Route::post('/admin/places', [PlacesController::class, 'store']);

    Route::get('/admin/types', [SeatTypesController::class, 'index']);

    Route::get('/admin/films', [FilmsController::class, 'index'])->name('admin-films');
    Route::post('/admin/films', [FilmsController::class, 'store']);
    Route::delete('/admin/films/{id}', [FilmsController::class, 'destroy']);

    Route::get('/admin/sessions', [FilmSessionsController::class, 'index']);
    Route::post('/admin/sessions', [FilmSessionsController::class, 'store'])->middleware(SessionIsValid::class);
    Route::delete('/admin/sessions/{id}', [FilmSessionsController::class, 'destroy']);
});

Auth::routes();
