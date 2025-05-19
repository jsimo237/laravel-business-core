<?php

use Illuminate\Support\Facades\Route;
use Kirago\BusinessCore\Modules\SecurityManagement\Controllers\LoginController;

Route::get('/test-auth', function () {
    return response()->json(['message' => 'Auth route loaded']);
});
Route::prefix('auth')->name('auth.')->group(function () {

    Route::group(function () {
        Route::post('login', [LoginController::class, 'login'])->name('login');
       // Route::post('register', [RegisterController::class, 'register'])->name('register');
    });

//    Route::middleware("auth:$guard")->group(function () {
//        Route::get('verify-email', EmailVerificationPromptController::class)
//                    ->name('verification.notice');
//
//        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//                    ->middleware(['signed', 'throttle:6,1'])
//                    ->name('verification.verify');
//
//        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                    ->middleware('throttle:6,1')
//                    ->name('verification.send');
//
//        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
//                    ->name('password.confirm');
//
//        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
//
//        Route::put('password', [PasswordController::class, 'update'])->name('password.update');
//
//        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
//                    ->name('logout');
//        Route::post('logout', [AuthenticatedSessionControllerTest::class, 'destroy'])
//                    ->name('logout.test');
//    });
});
