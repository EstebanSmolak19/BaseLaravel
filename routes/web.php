<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'index')->name('login');
    Route::post('/', 'login')->name('login.submit');
    Route::get('/logout', 'logout')->name('logout');
}); 

Route::middleware('auth')->group(function() {
    Route::resource('/app', EventController::class);
})


?>