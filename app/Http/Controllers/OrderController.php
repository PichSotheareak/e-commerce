<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function fetchOrder()
    {
        $data = DB::table("order")->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'     => 'required|exists:users,id',
            'user_id'         => 'required|exists:users,id', // staff
            'branch_id'       => 'required|exists:branch,id',
            'order_date'      => 'required|date',
            'total_amount'    => 'required|numeric|min:0',
            'status'          => 'required|string',
            'payment_status'  => 'required|string',
            'remark'          => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $data = DB::table("order")->insert([
                'customer_id'    => $request->customer_id,
                'user_id'        => $request->user_id,
                'branch_id'      => $request->branch_id,
                'order_date'     => $request->order_date,
                'total_amount'   => $request->total_amount,
                'status'         => $request->status,
                'payment_status' => $request->payment_status,
                'remark'         => $request->remark,
                'created_at'     => now(),
            ]);

            return response()->json([
                'success' => (bool)$data,
                'message' => $data ? 'Order added successfully.' : 'Failed to add order.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'             => 'required|exists:order,id',
            'customer_id'    => 'required|exists:users,id',
            'user_id'        => 'required|exists:users,id',
            'branch_id'      => 'required|exists:branch,id',
            'order_date'     => 'required|date',
            'total_amount'   => 'required|numeric|min:0',
            'status'         => 'required|string',
            'payment_status' => 'required|string',
            'remark'         => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 400);
        }

        try {
            $updated = DB::table('order')
                ->where('id', $request->id)
                ->whereNull('deleted_at')
                ->update([
                    'customer_id'    => $request->customer_id,
                    'user_id'        => $request->user_id,
                    'branch_id'      => $request->branch_id,
                    'order_date'     => $request->order_date,
                    'total_amount'   => $request->total_amount,
                    'status'         => $request->status,
                    'payment_status' => $request->payment_status,
                    'remark'         => $request->remark,
                    'updated_at'     => now(),
                ]);

            return response()->json([
                'success' => (bool)$updated,
                'message' => $updated ? 'Order updated successfully.' : 'No changes made to order.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    public function deleteOrder(Request $request)
    {
        $order = Order::find($request->id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ]);
        }

        $order->delete();

        return response()->json([
            'success' => (bool)$order,
            'message' => $order ? 'Customer deleted successfully.' : 'Failed to delete Customer.',
        ]);
    }
}
