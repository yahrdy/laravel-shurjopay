<?php

use Illuminate\Support\Facades\Route;
use Yahrdy\Shurjopay\Http\Controllers\ShurjoPayController;

Route::prefix('api/shurjopay')->group(function () {
    Route::post('initiate', [ShurjoPayController::class, 'initiate']);
    Route::get('verify', [ShurjoPayController::class, 'verify'])->name('shurjopay.verify');
    Route::get('check', [ShurjoPayController::class, 'check'])->name('shurjopay.check');
});
