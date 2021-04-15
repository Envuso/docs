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

    Route::prefix('1.x')->group(function() {
        Route::view('/release-notes', 'v1\release-notes')->name('release-notes');
        Route::view('/contribute', 'v1\contribute')->name('contribute');
        Route::view('/setup', 'v1\setup')->name('setup');
        Route::view('/routes', 'v1\routes')->name('routes');
        Route::view('/controllers', 'v1\controllers')->name('controllers');
        Route::view('/middleware', 'v1\middleware')->name('middleware');
        Route::view('/request', 'v1\request')->name('request');
        Route::view('/response', 'v1\response')->name('response');
        Route::view('/authentication', 'v1\authentication')->name('authentication');
        Route::view('/decorators', 'v1\decorators')->name('decorators');
        Route::view('/models', 'v1\models')->name('models');
        Route::view('/query-builder', 'v1\query-builder')->name('query-builder');
        Route::view('/cli', 'v1\cli')->name('cli');
        Route::view('/introduction', 'v1\introduction')->name('introduction');

    });

});

