<?php

use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-staff', [StaffController::class, 'fetchStaff']);
Route::post('/admin_api/add-staff', [StaffController::class, 'addStaff']);
Route::post('/admin_api/update-staff', [StaffController::class, 'updateStaff']);
Route::post('/admin_api/delete-staff', [StaffController::class, 'deleteStaff']);
