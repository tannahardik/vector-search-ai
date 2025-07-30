<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;


Route::get('/', [SearchController::class, 'index'])->name('search.form');

// Search action
Route::post('/search', [SearchController::class, 'search'])->name('search');
