<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [App\Http\Controllers\HomeController::class, 'getUsers'])->name('users');

Route::post('/loginsil', [App\Http\Controllers\HomeController::class, 'login2'])->name('login.2');

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::get('/devices', [App\Http\Controllers\HomeController::class, 'devices'])->name('devices');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/hubs', [App\Http\Controllers\HomeController::class, 'hubs'])->name('hubs');

    Route::get('/errors', [App\Http\Controllers\HomeController::class, 'errors'])->name('errors');



    Route::post('/devices', [App\Http\Controllers\HomeController::class, 'getDevices'])->name('devices.get')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/hub/get', [App\Http\Controllers\HomeController::class, 'getHubInfo'])->name('hub.get')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);


    

});



