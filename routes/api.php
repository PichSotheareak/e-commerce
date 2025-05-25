<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

include "admin_api/user.php";
include "admin_api/branch.php";
include "admin_api/category.php";
include "admin_api/product.php";
include "admin_api/user_role.php";
include "admin_api/customer.php";
include "admin_api/order.php";
