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

Route::prefix('1.x')->group(function () {
    Route::view('/release-notes', 'v1.release-notes')->name('release-notes');
    Route::view('/contribute', 'v1.contribute')->name('contribute');
    Route::view('/setup', 'v1.setup')->name('setup');

    Route::view('/decorators', 'v1.decorators')->name('decorators');

    Route::name('http.')->group(function () {
        Route::view('/routes', 'v1.http.routes')->name('routes');
        Route::view('/request', 'v1.http.request')->name('request');
        Route::view('/response', 'v1.http.response')->name('response');
        Route::view('/controllers', 'v1.http.controllers')->name('controllers');
        Route::view('/middleware', 'v1.http.middleware')->name('middleware');
    });

    Route::name('db.')->group(function () {
        Route::view('/models', 'v1.database.models')->name('models');
        Route::view('/query-builder', 'v1.database.query-builder')->name('query-builder');
        Route::view('/seeders', 'v1.database.seeders')->name('seeders');
    });

    Route::name('auth.')->group(function () {
        Route::view('/authentication', 'v1.auth.authentication')->name('authentication');
        Route::view('/policies', 'v1.auth.policies')->name('policies');
    });
    Route::name('websockets.')->group(function () {
        Route::view('/server', 'v1.websockets.server')->name('server');
        Route::view('/client', 'v1.websockets.client')->name('client');
    });

    Route::name('additional.')->group(function () {
        Route::view('/cache', 'v1.additional.cache')->name('cache');
        Route::view('/storage', 'v1.additional.storage')->name('storage');
        Route::view('/encryption-hashing', 'v1.additional.encryption-hashing')->name('encryption-hashing');
        Route::view('/data-transfer-objects', 'v1.additional.data-transfer-objects')->name('data-transfer-objects');
    });

    Route::view('/cli', 'v1.cli')->name('cli');
    Route::view('/introduction', 'v1.introduction')->name('introduction');

});

