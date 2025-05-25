<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-category', [CategoryController::class, 'fetchCategory']);
Route::post('/admin_api/add-category', [CategoryController::class, 'addCategory']);
Route::post('/admin_api/update-category', [CategoryController::class, 'updateCategory']);
Route::post('/admin_api/delete-category', [CategoryController::class, 'deleteCategory']);
