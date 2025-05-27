<?php

use App\Http\Controllers\OrderDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-order-detail', [OrderDetailController::class, 'fetchOrderDetail']);
Route::post('/admin_api/add-order-detail', [OrderDetailController::class, 'addOrderDetail']);
Route::post('/admin_api/update-order-detail', [OrderDetailController::class, 'updateOrderDetail']);
Route::post('/admin_api/delete-order-detail', [OrderDetailController::class, 'deleteOrderDetail']);
