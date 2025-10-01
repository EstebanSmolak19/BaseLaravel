<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Routes d'authentification
Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'index')->name('login');
    Route::post('/', 'login')->name('login.submit');
    Route::get('/logout', 'logout')->name('logout');
}); 

// Routes protégées par l'authentification
Route::middleware('auth')->group(function() {

    Route::resource('/app', EventController::class);

    // Routes admin
    Route::middleware(AdminMiddleware::class)
        ->prefix('/admin')
        ->name('admin.')
        ->controller(AdminController::class)
        ->group(function() {
            Route::get('/dashboard', 'index')->name('dashboard');
    });
});

?>