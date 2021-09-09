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
Route::redirect('/', '/v2/setup')->name('landing');

$versions = [
    'v1',
    'v2',
];

foreach ($versions as $version) {
    Route::prefix($version)->middleware('version:' . $version)->group(function () use ($version) {
        Route::view('/release-notes', $version . '.release-notes')->name($version . '.release-notes');
        Route::view('/contribute', $version . '.contribute')->name($version . '.contribute');
        Route::view('/setup', $version . '.setup')->name($version . '.setup');

        Route::view('/decorators', $version . '.decorators')->name($version . '.decorators');

        Route::name('http.')->group(function () use ($version) {
            Route::view('/routes', $version . '.http.routes')->name($version . '.routes');
            Route::view('/request', $version . '.http.request')->name($version . '.request');
            Route::view('/response', $version . '.http.response')->name($version . '.response');
            Route::view('/controllers', $version . '.http.controllers')->name($version . '.controllers');
            Route::view('/middleware', $version . '.http.middleware')->name($version . '.middleware');
        });

        Route::name('db.')->group(function () use ($version) {
            Route::view('/models', $version . '.database.models')->name($version . '.models');
            Route::view('/query-builder', $version . '.database.query-builder')->name($version . '.query-builder');
            Route::view('/seeders', $version . '.database.seeders')->name($version . '.seeders');
        });

        Route::name('auth.')->group(function () use ($version) {
            Route::view('/authentication', $version . '.auth.authentication')->name($version . '.authentication');
            Route::view('/policies', $version . '.auth.policies')->name($version . '.policies');
        });
        Route::name('websockets.')->group(function () use ($version) {
            Route::view('/server', $version . '.websockets.server')->name($version . '.server');
            Route::view('/client', $version . '.websockets.client')->name($version . '.client');
        });

        Route::name('additional.')->group(function () use ($version) {
            Route::view('/cache', $version . '.additional.cache')->name($version . '.cache');
            Route::view('/storage', $version . '.additional.storage')->name($version . '.storage');
            Route::view('/encryption-hashing', $version . '.additional.encryption-hashing')->name($version . '.encryption-hashing');
            Route::view('/data-transfer-objects', $version . '.additional.data-transfer-objects')->name($version . '.data-transfer-objects');
        });

        Route::view('/cli', $version . '.cli')->name($version . '.cli');
        Route::view('/introduction', $version . '.introduction')->name($version . '.introduction');

    });
}

