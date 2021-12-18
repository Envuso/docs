<?php

use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;


Route::middleware([])->group(function () {
    Route::get('/', [DocumentationController::class, 'redirect']);
    Route::get('/{page}', [DocumentationController::class, 'page'])->name('page')->where('page', '.*');
});

