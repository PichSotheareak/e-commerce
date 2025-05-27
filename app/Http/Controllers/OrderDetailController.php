<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    public function fetchOrderDetail()
    {
        $data = DB::table('order_detail')->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addOrderDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
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
            $data = DB::table('order_detail')->insert([
                'order_id' => $validated['order_id'],
                'product_id' => $validated['product_id'],
                'qty' => $validated['qty'],
                'price' => $validated['price'],
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => (bool)$data,
                'message' => $data ? 'Order detail added successfully.' : 'Failed to add order detail.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateOrderDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:order_detail,id',
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $updateData =[
                'order_id' => $request -> order_id,
                'product_id' => $request -> product_id,
                'qty' => $request -> qty,
                'price' => $request -> price,
                'updated_at' => now(),
            ];

            $updated = DB::table('order_detail')
                ->where('id', $request->id)
                ->whereNull('deleted_at')
                ->update($updateData);

            return response()->json([
                'success' => (bool)$updated,
                'message' => $updated ? 'Order detail updated successfully.' : 'Failed to update order detail.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteOrderDetail(Request $request)
    {
        $orderDetail = OrderDetail::find($request->id);

        if (!$orderDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Order detail not found.'
            ]);
        }

        $orderDetail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order detail deleted successfully.'
        ]);
    }
}
