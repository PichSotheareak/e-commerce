<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    public function fetchPaymentMethod()
    {
        $data = DB::table("payment_method")
            ->select('*')
            ->whereNull('deleted_at')
            ->get();

        return response()->json($data);
    }

    public function addPaymentMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:100',
            'account_number'  => 'nullable|string|max:50',
            'qrcode'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        try {
            $qrPath = asset('storage/images/no-image.png');
            if ($request->hasFile('qrcode')) {
                $qrPath = $request->file('qrcode')->store('images/payment_qr', 'public');
            }

            $data = DB::table("payment_method")->insert([
                'name'           => $validated['name'],
                'account_number' => $validated['account_number'] ?? null,
                'qrcode'         => $qrPath,
                'created_at'     => now(),
            ]);

            return response()->json([
                'success' => (bool) $data,
                'message' => $data ? 'Payment method added successfully.' : 'Failed to add payment method.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function updatePaymentMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'              => 'required|exists:payment_method,id',
            'name'            => 'required|string|max:100',
            'account_number'  => 'nullable|string|max:50',
            'qrcode'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        try {
            $qrPath = asset('storage/images/no-image.png');
            if ($request->hasFile('qrcode')) {
                $qrPath = $request->file('qrcode')->store('images/payment_qr', 'public');
            }

            $updateData = [
                'name'           => $request->name,
                'account_number' => $request->account_number,
                'updated_at'     => now(),
            ];

            if ($qrPath) {
                $updateData['qrcode'] = $qrPath;
            }

            $updated = DB::table("payment_method")
                ->where('id', $request->id)
                ->whereNull('deleted_at')
                ->update($updateData);

            return response()->json([
                'success' => (bool) $updated,
                'message' => $updated ? 'Payment method updated successfully.' : 'Failed to update payment method.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function deletePaymentMethod(Request $request)
    {
        $paymentMethod = PaymentMethod::find($request->id);

        if (!$paymentMethod) {
            return response()->json([
                'success' => false,
                'message' => 'Payment method not found.'
            ]);
        }

        $paymentMethod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment method deleted successfully.'
        ]);
    }
}
