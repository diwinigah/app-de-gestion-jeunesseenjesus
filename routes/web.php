<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PublicRegistrationListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/camp', [RegistrationController::class, 'show'])
    ->name('registration.show');

Route::post('/camp', [RegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('registration.store');

Route::get('/camp/confirmation', [RegistrationController::class, 'confirmation'])
    ->name('registration.confirmation');

Route::get('/inscrits', [PublicRegistrationListController::class, 'index'])
    ->name('public.registrations.index');

Route::get('/projets', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projets/{project:slug}', [ProjectController::class, 'show'])
    ->name('projects.show');
