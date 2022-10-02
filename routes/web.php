<?php

use App\Http\Middleware\SessionIsValid;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HallsController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\TypesController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\OrdersController;

Route::get('/', function () {
    return view('client/index');
});

Route::get('/client/films', [FilmsController::class, 'index']);
Route::get('/client/films/{id}', [FilmsController::class, 'show']);

Route::get('/client/halls/{id}', [HallsController::class, 'show']);

Route::get('/client/places', [PlacesController::class, 'index']);

Route::get('/client/types', [TypesController::class, 'index']);

Route::get('/client/orders', [OrdersController::class, 'index']);
Route::post('/client/orders', [OrdersController::class, 'store']);

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

    Route::get('/admin/types', [TypesController::class, 'index']);

    Route::get('/admin/films', [FilmsController::class, 'index'])->name('admin-films');
    Route::post('/admin/films', [FilmsController::class, 'store']);
    Route::delete('/admin/films/{id}', [FilmsController::class, 'destroy']);

    Route::get('/admin/sessions', [SessionsController::class, 'index']);
    Route::post('/admin/sessions', [SessionsController::class, 'store'])->middleware(SessionIsValid::class);
    Route::delete('/admin/sessions/{id}', [SessionsController::class, 'destroy']);
});

Auth::routes();
