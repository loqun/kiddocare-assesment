<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/booking', function () {
    return Inertia::render('KiddoCareHome');
})->name('get-kiddocare-home');

//Kiddocare route no need login let say if need just add the middleware and the login page 
Route::post('/booking',[BookingController::class, 'bookingForm'])->name('post-kiddocare-home');

Route::get('/confirmation-page', [BookingController::class, 'confirmationPage' ])->name('confirmation-page');



//





require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
