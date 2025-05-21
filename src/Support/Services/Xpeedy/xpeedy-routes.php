<?php


use Illuminate\Support\Facades\Route;
use Kirago\BusinessCore\Support\Services\Xpeedy\XpeedyController;


Route::prefix('xpeedy-payments')
    ->name('api.xpeedy.wallet')
    ->group( function (){
    // Cette route permet d'initier une transaction

    Route::post('init',[XpeedyController::class,'init'])->name('init');

    Route::get('check/{transactionId}',[XpeedyController::class,'check'])->name('check');

    Route::get('wallet-details',[XpeedyController::class,'getWalletDetails'])->name('wallet.details');

});



