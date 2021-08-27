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

Route::redirect('/', '/1.x/setup')->name('landing');

Route::name('overview.')->group(function () {

    Route::prefix('1.x')->group(function () {
        Route::view('/release-notes', 'v1.release-notes')->name('release-notes');
        Route::view('/contribute', 'v1.contribute')->name('contribute');
        Route::view('/setup', 'v1.setup')->name('setup');
        Route::view('/routes', 'v1.routes')->name('routes');
        Route::view('/controllers', 'v1.controllers')->name('controllers');
        Route::view('/data-transfer-objects', 'v1.data-transfer-objects')->name('data-transfer-objects');
        Route::view('/middleware', 'v1.middleware')->name('middleware');
        Route::view('/request', 'v1.request')->name('request');
        Route::view('/response', 'v1.response')->name('response');
        Route::view('/decorators', 'v1.decorators')->name('decorators');
        Route::name('db.')->group(function () {
            Route::view('/models', 'v1.database.models')->name('models');
            Route::view('/query-builder', 'v1.database.query-builder')->name('query-builder');
            Route::view('/seeders', 'v1.database.seeders')->name('seeders');
        });
        Route::name('auth.')->group(function () {
            Route::view('/authentication', 'v1.auth.authentication')->name('authentication');
            Route::view('/policies', 'v1.auth.policies')->name('policies');
        });
        Route::view('/cli', 'v1.cli')->name('cli');
        Route::view('/introduction', 'v1.introduction')->name('introduction');

    });

});

