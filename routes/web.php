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

Route::redirect('/', '/setup')->name('landing');

Route::name('overview.')->group(function () {

    Route::view('/release-notes', 'release-notes')->name('release-notes');
    Route::view('/contribute', 'contribute')->name('contribute');
    Route::view('/setup', 'setup')->name('setup');
    Route::view('/routes', 'routes')->name('routes');
    Route::view('/controllers', 'controllers')->name('controllers');
    Route::view('/middleware', 'middleware')->name('middleware');
    Route::view('/request', 'request')->name('request');
    Route::view('/response', 'response')->name('response');
    Route::view('/authentication', 'authentication')->name('authentication');
    Route::view('/decorators', 'decorators')->name('decorators');
    Route::view('/models', 'models')->name('models');
    Route::view('/query-builder', 'query-builder')->name('query-builder');
    Route::view('/cli', 'cli')->name('cli');


    Route::view('/introduction', 'introduction')->name('introduction');

});

