<?php

use App\Http\Controllers\PrivateFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/private-files/{path}', [PrivateFileController::class, 'serve'])
    ->where('path', '.*')
    ->middleware('auth')
    ->name('private-files');
