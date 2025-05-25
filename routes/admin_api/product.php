<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-product', [ProductController::class, 'fetchProduct']);
Route::post('/admin_api/add-product', [ProductController::class, 'addProduct']);
Route::post('/admin_api/update-product', [ProductController::class, 'updateProduct']);
Route::post('/admin_api/delete-product', [ProductController::class, 'deleteProduct']);
