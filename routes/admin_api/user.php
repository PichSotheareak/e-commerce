<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-user', [UserController::class, 'fetchUser']);
Route::post('/admin_api/add-user', [UserController::class, 'addUser']);
Route::post('/admin_api/update-user', [UserController::class, 'updateUser']);
Route::post('/admin_api/delete-user', [UserController::class, 'deleteUser']);
