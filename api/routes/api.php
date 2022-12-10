<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/redirect', [RedirectController::class, 'listagem']);
Route::post('/redirect', [RedirectController::class, 'store']);


