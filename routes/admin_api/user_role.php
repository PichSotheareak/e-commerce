<?php

use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-user-role', [UserRoleController::class, 'fetchUserRole']);
Route::post('/admin_api/add-user-role', [UserRoleController::class, 'addUserRole']);
Route::post('/admin_api/update-user-role', [UserRoleController::class, 'updateUserRole']);
Route::post('/admin_api/delete-user-role', [UserRoleController::class, 'deleteUserRole']);
