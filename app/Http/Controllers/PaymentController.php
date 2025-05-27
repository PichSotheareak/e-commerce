<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    // ✅ Fetch all payments (not soft deleted)
    public function fetchPayment()
    {
        $data = DB::table("payment")
            ->select('*')
            ->whereNull('deleted_at')
            ->get();

        return response()->json($data);
    }

    // ✅ Add new payment
    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id'        => 'required|integer|exists:invoices,id',
            'payment_date'      => 'required|date',
            'amount'            => 'required|numeric|min:0',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'branch_id'         => 'required|integer|exists:branches,id',
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
            $insert = DB::table("payment")->insert([
                'invoice_id'        => $validated['invoice_id'],
                'payment_date'      => $validated['payment_date'],
                'amount'            => $validated['amount'],
                'payment_method_id' => $validated['payment_method_id'],
                'branch_id'         => $validated['branch_id'],
                'created_at'        => now(),
            ]);

            return response()->json([
                'success' => (bool) $insert,
                'message' => $insert ? 'Payment added successfully.' : 'Failed to add payment.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // ✅ Update payment
    public function updatePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'                => 'required|exists:payment,id',
            'invoice_id'        => 'required|integer|exists:invoices,id',
            'payment_date'      => 'required|date',
            'amount'            => 'required|numeric|min:0',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'branch_id'         => 'required|integer|exists:branches,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        try {
            $updated = DB::table("payment")
                ->where('id', $request->id)
                ->whereNull('deleted_at')
                ->update([
                    'invoice_id'        => $request->invoice_id,
                    'payment_date'      => $request->payment_date,
                    'amount'            => $request->amount,
                    'payment_method_id' => $request->payment_method_id,
                    'branch_id'         => $request->branch_id,
                    'updated_at'        => now(),
                ]);

            return response()->json([
                'success' => (bool) $updated,
                'message' => $updated ? 'Payment updated successfully.' : 'Failed to update payment.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // ✅ Soft delete payment
    public function deletePayment(Request $request)
    {
        $payment = Payment::find($request->id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found.'
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully.'
        ]);
    }
}
