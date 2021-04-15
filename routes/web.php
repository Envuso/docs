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

    Route::view('/1.x/release-notes', 'v1\release-notes')->name('release-notes');
    Route::view('/1.x/contribute', 'v1\contribute')->name('contribute');
    Route::view('/1.x/setup', 'v1\setup')->name('setup');
    Route::view('/1.x/routes', 'v1\routes')->name('routes');
    Route::view('/1.x/controllers', 'v1\controllers')->name('controllers');
    Route::view('/1.x/middleware', 'v1\middleware')->name('middleware');
    Route::view('/1.x/request', 'v1\request')->name('request');
    Route::view('/1.x/response', 'v1\response')->name('response');
    Route::view('/1.x/authentication', 'v1\authentication')->name('authentication');
    Route::view('/1.x/decorators', 'v1\decorators')->name('decorators');
    Route::view('/1.x/models', 'v1\models')->name('models');
    Route::view('/1.x/query-builder', 'v1\query-builder')->name('query-builder');
    Route::view('/1.x/cli', 'v1\cli')->name('cli');


    Route::view('/1.x/introduction', 'v1\introduction')->name('introduction');

});

