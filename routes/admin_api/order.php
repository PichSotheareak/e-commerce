<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-order', [OrderController::class, 'fetchOrder']);
Route::post('/admin_api/add-order', [OrderController::class, 'addOrder']);
Route::post('/admin_api/update-order', [OrderController::class, 'updateOrder']);
Route::post('/admin_api/delete-order', [OrderController::class, 'deleteOrder']);
