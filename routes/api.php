<?php

use Illuminate\Support\Facades\Route;
use Yahrdy\Shurjopay\Http\Controllers\ShurjoPayController;

Route::prefix('api/shurjopay')->group(function () {
    Route::get('initiate', [ShurjoPayController::class, 'initiatePayment']);
    Route::post('response', [ShurjoPayController::class, 'response'])->name('shurjopay.response');
    Route::get('verify', [ShurjoPayController::class, 'verifyPayment']);
});
