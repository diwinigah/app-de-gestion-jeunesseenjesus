<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/camp', [RegistrationController::class, 'show'])
    ->name('registration.show');

Route::post('/camp', [RegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('registration.store');
