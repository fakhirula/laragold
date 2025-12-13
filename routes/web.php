<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\PriceController;

Route::get('/', function () {
    return Inertia::render('Home', [
        'historicalPrices' => [],
        'selectedDays' => 0,
    ]);
})->name('home');

Route::get('/login', function () {
    return Inertia::render('auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('auth/Register');
})->name('register');

Route::get('/profiles', function () {
    return Inertia::render('profiles/ProfileIndex');
})->name('profiles.index');

Route::get('/profiles/me', function () {
    return Inertia::render('profiles/ProfilePage', [
        'user' => [
            'name' => 'Client Sample',
            'email' => 'client@laragold.local',
            'kyc' => false,
        ],
    ]);
})->name('profiles.me');

Route::get('/prices', [PriceController::class, 'index'])->name('prices');

require __DIR__.'/settings.php';
