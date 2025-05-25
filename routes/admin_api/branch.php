<?php

use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-bra nch', [BranchController::class, 'fetchBranch']);
Route::post('/admin_api/add-branch', [BranchController::class, 'addBranch']);
Route::post('/admin_api/update-branch', [BranchController::class, 'updateBranch']);
Route::post('/admin_api/delete-branch', [BranchController::class, 'deleteBranch']);
