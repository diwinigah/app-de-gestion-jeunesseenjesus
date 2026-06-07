<?php

use App\Http\Controllers\Investor\InvestorAuthController;
use App\Http\Controllers\Investor\InvestorController;
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

// Projets publics
Route::get('/projets', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projets/{project:slug}', [ProjectController::class, 'show'])
    ->name('projects.show');

// Investisseur - Authentification
Route::prefix('investisseur')->group(function (): void {
    Route::middleware('guest:investor')->group(function (): void {
        Route::get('inscription', [InvestorAuthController::class, 'showRegister'])
            ->name('investor.register');
        Route::post('inscription', [InvestorAuthController::class, 'register']);

        Route::get('connexion', [InvestorAuthController::class, 'showLogin'])
            ->name('investor.login');
        Route::post('connexion', [InvestorAuthController::class, 'login']);
    });

    Route::middleware('auth:investor')->group(function (): void {
        Route::post('deconnexion', [InvestorAuthController::class, 'logout'])
            ->name('investor.logout');

        Route::get('tableau-de-bord', [InvestorAuthController::class, 'dashboard'])
            ->name('investor.dashboard');
    });
});

// Investissements
Route::prefix('projets')->group(function (): void {
    Route::get('{project:slug}/investir', [InvestorController::class, 'showInvestForm'])
        ->name('projects.invest.form');

    Route::post('{project:slug}/investir', [InvestorController::class, 'invest'])
        ->middleware('auth:investor')
        ->name('projects.invest');
});

