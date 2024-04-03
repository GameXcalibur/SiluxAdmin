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
Route::get('/logview', [App\Http\Controllers\HomeController::class, 'logViewer'])->name('logViewer');
Route::get('/huboffline', [App\Http\Controllers\HomeController::class, 'hubOffline'])->name('hubOffline');
Route::get('/hsbcactive', [App\Http\Controllers\HomeController::class, 'hsbcactive'])->name('hsbcactive');



Route::get('/users', [App\Http\Controllers\HomeController::class, 'getUsers'])->name('users');

Route::get('/cellRep', [App\Http\Controllers\HomeController::class, 'hsbcCellReport'])->name('cellRep');
Route::get('/lastOnlineRef', [App\Http\Controllers\HomeController::class, 'lastOnlineRef'])->name('lastOnlineRef');



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

    Route::get('/heatdash', [App\Http\Controllers\HomeController::class, 'heatdash'])->name('heatdash');


    Route::get('/errors', [App\Http\Controllers\HomeController::class, 'errors'])->name('errors');
    Route::get('/hubTest', [App\Http\Controllers\HomeController::class, 'hubTest'])->name('hubTest');



    Route::post('/devices', [App\Http\Controllers\HomeController::class, 'getDevices'])->name('devices.get')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/hub/get', [App\Http\Controllers\HomeController::class, 'getHubInfo'])->name('hub.get')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/hub/schedule/get', [App\Http\Controllers\HomeController::class, 'getSchedule'])->name('hub.get.schedule')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/hub/device/delete', [App\Http\Controllers\HomeController::class, 'deleteDevice'])->name('hub.delete.device')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);


    Route::post('/hub/init', [App\Http\Controllers\HomeController::class, 'hubOverviewInit'])->name('hub.init')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);



    

});



