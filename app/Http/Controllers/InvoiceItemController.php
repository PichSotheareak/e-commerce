<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceItemController extends Controller
{
    public function fetchInvoiceItem()
    {
        $data = DB::table("invoice_item")->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addInvoiceItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|integer',
            'product_id' => 'required|integer',
            'qty'        => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
            'sub_total'  => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        try {
            $data = DB::table("invoice_item")->insert([
                'invoice_id' => $validated['invoice_id'],
                'product_id' => $validated['product_id'],
                'qty'        => $validated['qty'],
                'price'      => $validated['price'],
                'sub_total'  => $validated['sub_total'],
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => (bool) $data,
                'message' => $data ? 'Invoice item added successfully.' : 'Failed to add invoice item.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function updateInvoiceItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'         => 'required|integer|exists:invoice_item,id',
            'invoice_id' => 'required|integer',
            'product_id' => 'required|integer',
            'qty'        => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
            'sub_total'  => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        try {
            $updateData = [
                'invoice_id' => $$request -> invoice_id,
                'product_id' => $$request -> product_id,
                'qty'        => $$request -> qty,
                'price'      => $$request -> price,
                'sub_total'  => $$request -> sub_total,
                'updated_at' => now(),
            ];

            $updated = DB::table("invoice_item")
                ->where('id', $request ->id)
                ->whereNull('deleted_at')
                ->update($updateData);

            return response()->json([
                'success' => (bool) $updated,
                'message' => $updated ? 'Invoice item updated successfully.' : 'Failed to update invoice item.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function deleteInvoiceItem(Request $request)
    {
        $invoiceItem = InvoiceItem::find($request->id);

        if(!$invoiceItem){
            return response()->json([
                'success' => false,
                'message' => 'Invoice item not found.'
            ]);
        }

        $invoiceItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice item deleted successfully.'
        ]);
    }
}
