<?php


/*
|--------------------------------------------------------------------------
| DASHBOARD Routes
|--------------------------------------------------------------------------
|
| Your Text Here ...
|
*/

use InitSoftBot\Http\Controllers\Dashboard\{AppController};

Route::domain('dashboard.'.env('APP_DOMAIN'))->group(function () {
    Route::get('apps', [AppController::class, 'index'])->name('dashboard.apps.index');
    Route::post('apps', [AppController::class, 'store'])->name('dashboard.apps.store');
});


Route::domain('{website}.'.env('APP_DOMAIN'))->group(function () {
    Route::get('/', function ($website) {
        return $website;
    });
});
