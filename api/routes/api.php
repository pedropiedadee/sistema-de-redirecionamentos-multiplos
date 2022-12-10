<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/redirects', [RedirectController::class, 'listagem']);
Route::get('/redirect/{redirect}', [RedirectController::class, 'show']);
Route::post('/redirect', [RedirectController::class, 'store']);
Route::post('/redirect/{redirect}/links', [RedirectController::class, 'addLink']);




