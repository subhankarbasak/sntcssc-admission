<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\ApplicationController;
use App\Models\Advertisement;
use App\Models\Application;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);
// Route::get('/dashboard', function() {
//     return view('dashboard');
// })->middleware('auth')->name('dashboard');


Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware([\App\Http\Middleware\RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
 
    Route::get('/profile', function () {
        // ...
    })->withoutMiddleware([\App\Http\Middleware\RedirectIfAuthenticated::class]);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/application/{advertisement:code}/apply', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/application/{advertisement:code}/step1', [ApplicationController::class, 'storeStep1'])->name('application.store.step1');
    Route::get('/application/{application:application_number}/communication', [ApplicationController::class, 'step2'])->name('application.step2');
    Route::post('/application/{application:application_number}/step2', [ApplicationController::class, 'storeStep2'])->name('application.store.step2');
    Route::get('/application/{application:application_number}/other-details', [ApplicationController::class, 'step3'])->name('application.step3');
    Route::post('/application/{application:application_number}/step3', [ApplicationController::class, 'storeStep3'])->name('application.store.step3');
    Route::get('/application/{application:application_number}/document-upload', [ApplicationController::class, 'step4'])->name('application.step4');
    Route::post('/application/{application:application_number}/step4', [ApplicationController::class, 'storeStep4'])->name('application.store.step4');
    Route::get('/application/{application:application_number}/review', [ApplicationController::class, 'step5'])->name('application.step5');
    Route::post('/application/{application:application_number}/submit', [ApplicationController::class, 'submit'])->name('application.submit');
    Route::get('/application/{application:application_number}/payment', [ApplicationController::class, 'payment'])->name('application.payment');
    Route::post('/application/{application:application_number}/payment', [ApplicationController::class, 'storePayment'])->name('application.store.payment');
    Route::get('/application/{application:application_number}/status', [ApplicationController::class, 'status'])->name('application.status');
    Route::get('/application/{application:application_number}/download', [ApplicationController::class, 'download'])->name('application.download');

    // routes/web.php
    Route::get('/application/upsc-attempt-template', [ApplicationController::class, 'getUpscAttemptTemplate'])
        ->name('application.upsc-attempt-template');
});

Route::post('/validate/secondary_roll', [RegisterController::class, 'validateSecondaryRoll'])->name('validate.secondary_roll');
Route::post('/validate/email', [RegisterController::class, 'validateEmail'])->name('validate.email');
Route::post('/validate/mobile', [RegisterController::class, 'validateMobile'])->name('validate.mobile');

Route::get('/test-auth', function () {
    return auth()->check() ? 'Logged in' : 'Not logged in';
});

Route::get('/test-error', function () {
    throw new \Exception('Test 500 error');
});