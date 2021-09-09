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

$version = [
    'v1', 'v2'
];

foreach ($version as $versions) {
    Route::prefix($versions)->group(function () use ($versions) {
        Route::view('/release-notes', $versions.'.release-notes')->name($versions.'.release-notes');
        Route::view('/contribute', $versions.'.contribute')->name($versions.'.contribute');
        Route::view('/setup', $versions.'.setup')->name($versions.'.setup');

        Route::view('/decorators', $versions.'.decorators')->name($versions.'.decorators');

        Route::name('http.')->group(function () use ($versions) {
            Route::view('/routes', $versions.'.http.routes')->name($versions.'.routes');
            Route::view('/request', $versions.'.http.request')->name($versions.'.request');
            Route::view('/response', $versions.'.http.response')->name($versions.'.response');
            Route::view('/controllers', $versions.'.http.controllers')->name($versions.'.controllers');
            Route::view('/middleware', $versions.'.http.middleware')->name($versions.'.middleware');
        });

        Route::name('db.')->group(function () use ($versions) {
            Route::view('/models', $versions.'.database.models')->name($versions.'.models');
            Route::view('/query-builder', $versions.'.database.query-builder')->name($versions.'.query-builder');
            Route::view('/seeders', $versions.'.database.seeders')->name($versions.'.seeders');
        });

        Route::name('auth.')->group(function () use ($versions) {
            Route::view('/authentication', $versions.'.auth.authentication')->name($versions.'.authentication');
            Route::view('/policies', $versions.'.auth.policies')->name($versions.'.policies');
        });
        Route::name('websockets.')->group(function () use ($versions) {
            Route::view('/server', $versions.'.websockets.server')->name($versions.'.server');
            Route::view('/client', $versions.'.websockets.client')->name($versions.'.client');
        });

        Route::name('additional.')->group(function () use ($versions) {
            Route::view('/cache', $versions.'.additional.cache')->name($versions.'.cache');
            Route::view('/storage', $versions.'.additional.storage')->name($versions.'.storage');
            Route::view('/encryption-hashing', $versions.'.additional.encryption-hashing')->name($versions.'.encryption-hashing');
            Route::view('/data-transfer-objects', $versions.'.additional.data-transfer-objects')->name($versions.'.data-transfer-objects');
        });

        Route::view('/cli', $versions.'.cli')->name($versions.'.cli');
        Route::view('/introduction', $versions.'.introduction')->name($versions.'.introduction');

    });
}

