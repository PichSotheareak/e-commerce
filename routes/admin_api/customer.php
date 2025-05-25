<?php

use App\Http\Controllers\customerController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-customer', [CustomerController::class, 'fetchCustomer']);
Route::post('/admin_api/add-customer', [CustomerController::class, 'addCustomer']);
Route::post('/admin_api/update-customer', [CustomerController::class, 'updateCustomer']);
Route::post('/admin_api/delete-customer', [CustomerController::class, 'deleteCustomer']);
