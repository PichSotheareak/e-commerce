<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-invoice', [InvoiceController::class, 'fetchInvoice']);
Route::post('/admin_api/add-invoice', [InvoiceController::class, 'addInvoice']);
Route::post('/admin_api/update-invoice', [InvoiceController::class, 'updateInvoice']);
Route::post('/admin_api/delete-invoice', [InvoiceController::class, 'deleteInvoice']);
