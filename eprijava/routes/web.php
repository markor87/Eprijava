<?php

use App\Http\Controllers\CompetitionZipController;
use App\Http\Controllers\PrivateFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-competition-zip/{competition}', [CompetitionZipController::class, 'generate'])
    ->middleware('auth')
    ->name('competition-zip.generate');

Route::get('/download-competition-zip/{token}', [CompetitionZipController::class, 'download'])
    ->middleware('auth')
    ->name('competition-zip.download');

Route::get('/private-files/{path}', [PrivateFileController::class, 'serve'])
    ->where('path', '.*')
    ->middleware('auth')
    ->name('private-files');
