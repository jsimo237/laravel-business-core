<?php


use Illuminate\Support\Facades\Route;
use Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth\LoginController;
use Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth\LogoutController;
use Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth\MeController;
use Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth\OtpCodeController;
use Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth\RefreshTokenController;


Route::prefix('auth')
    ->name('api.auth')

    ->group( function (){

    Route::middleware(['has-auth-guard-header','guest:api'])
        ->group( function (){
            Route::post('login',[LoginController::class,'login'])
                ->name('login');
            Route::post('otpcode/verify',[OtpCodeController::class,'verify'])->name('otp.verify');
            Route::post('otpcode/resend',[OtpCodeController::class,'resend'])->name('otp.resend');
        });

    Route::middleware('auth:api')
        ->group( function (){

            Route::get('me', MeController::class)->name('me');
            Route::post('logout', [LogoutController::class,"logout"])->name('logout');
            Route::post('logout/all-devices', [LogoutController::class,"logout"])->name('logout-all-devices');

            Route::post('refesh', RefreshTokenController::class)->name('refesh');
        });

});



