<?php

use App\Http\Controllers\InvoiceItemController;
use Illuminate\Support\Facades\Route;

Route::get('/admin_api/get-invoice-item', [InvoiceItemController::class, 'fetchInvoiceItem']);
Route::post('/admin_api/add-invoice-item', [InvoiceItemController::class, 'addInvoiceItem']);
Route::post('/admin_api/update-invoice-item', [InvoiceItemController::class, 'updateInvoiceItem']);
Route::post('/admin_api/delete-invoice-item', [InvoiceItemController::class, 'deleteInvoiceItem']);
