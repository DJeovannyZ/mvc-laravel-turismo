<?php

use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PlaceController::class, 'index'])->name('places.index');
Route::get('/lugares/{slug}', [PlaceController::class, 'show'])->name('places.show');
