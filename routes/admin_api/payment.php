<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-payment', [PaymentController::class, 'fetchPayment']);
Route::post('/admin_api/add-payment', [PaymentController::class, 'addPayment']);
Route::post('/admin_api/update-payment', [PaymentController::class, 'updatePayment']);
Route::post('/admin_api/delete-payment', [PaymentController::class, 'deletePayment']);
