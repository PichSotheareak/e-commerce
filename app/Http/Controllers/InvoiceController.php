<?php

namespace App\Http\Controllers;


use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function fetchInvoice()
    {
        $data = DB::table('invoice')->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'           => 'required|integer',
            'customer_id'       => 'required|integer',
            'transaction_date'  => 'required|date',
            'pick_up_date_time' => 'required|date',
            'total_amount'      => 'required|numeric',
            'paid_amount'       => 'required|numeric',
            'status'            => 'required|string|max:50',
            'order_id'          => 'required|integer',
            'payment_method_id' => 'required|integer',
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
            $inserted = DB::table('invoice')->insert([
                'user_id'           => $validated['user_id'],
                'customer_id'       => $validated['customer_id'],
                'transaction_date'  => $validated['transaction_date'],
                'pick_up_date_time' => $validated['pick_up_date_time'],
                'total_amount'      => $validated['total_amount'],
                'paid_amount'       => $validated['paid_amount'],
                'status'            => $validated['status'],
                'order_id'          => $validated['order_id'],
                'payment_method_id' => $validated['payment_method_id'],
                'created_at'        => now(),
            ]);

            return response()->json([
                'success' => (bool) $inserted,
                'message' => $inserted ? 'Invoice added successfully.' : 'Failed to add invoice.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function updateInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'                => 'required|integer|exists:invoice,id',
            'user_id'           => 'required|integer',
            'customer_id'       => 'required|integer',
            'transaction_date'  => 'required|date',
            'pick_up_date_time' => 'required|date',
            'total_amount'      => 'required|numeric',
            'paid_amount'       => 'required|numeric',
            'status'            => 'required|string|max:50',
            'order_id'          => 'required|integer',
            'payment_method_id' => 'required|integer',
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
                'user_id'           => $request -> user_id,
                'customer_id'       => $request -> customer_id,
                'transaction_date'  => $request -> transaction_date,
                'pick_up_date_time' => $request -> pick_up_date_time,
                'total_amount'      => $request -> total_amount,
                'paid_amount'       => $request -> paid_amount,
                'status'            => $request -> status,
                'order_id'          => $request -> order_id,
                'payment_method_id' => $request -> payment_method_id,
                'updated_at'        => now(),
            ];

            $updated = DB::table('invoice')
                ->where('id', $request->id)
                ->whereNull('deleted_at')
                ->update($updateData);

            return response()->json([
                'success' => (bool) $updated,
                'message' => $updated ? 'Invoice updated successfully.' : 'Failed to update invoice.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function deleteInvoice(Request $request)
    {
        $dataInvoice = Invoice::find($request -> id);

        if (!$dataInvoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found.',
            ]);
        }

        $dataInvoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully.',
        ]);
    }
}
