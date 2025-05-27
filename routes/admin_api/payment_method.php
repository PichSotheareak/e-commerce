<?php

use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-payment-method', [PaymentMethodController::class, 'fetchPaymentMethod']);
Route::post('/admin_api/add-payment-method', [PaymentMethodController::class, 'addPaymentMethod']);
Route::post('/admin_api/update-payment-method', [PaymentMethodController::class, 'updatePaymentMethod']);
Route::post('/admin_api/delete-payment-method', [PaymentMethodController::class, 'deletePaymentMethod']);
