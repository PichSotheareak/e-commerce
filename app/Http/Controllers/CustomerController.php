<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function fetchCustomer()
    {
        $data = DB::table("customer")->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'email' => 'required|string|max:255|unique:customer',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|min:3',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $imagePath = 'images/default.jpg'; // fallback
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/customer', 'public');
            }
            $data = DB::table("customer")->insert([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'image' => $imagePath ,
                'password' => bcrypt($validated['password']),
                'created_at' => now(),

            ]);

            return response()->json([
                'success' => (bool) $data,
                'message' => $data ? 'Customer added successfully.' : 'Failed to add Customer .',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateCustomer(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $gender = $request->gender;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $password = $request->password;

        // Only attempt to store image if it exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        try {
            $updateData = [
                'name' => $name,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'password' => Hash::make($password),
                'updated_at' => now(),
            ];

            // Update image only if it's uploaded
            if ($imagePath) {
                $updateData['image'] = $imagePath;
            }

            $updated = DB::table("customer")
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->update($updateData);

            return response()->json([
                'success' => (bool) $updated,
                'message' => $updated ? 'User updated successfully.' : 'Failed to update user.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function deleteCustomer(Request $request)
    {
        $customer = Customer::find($request->id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Branch not found.'
            ]);
        }

        $customer->delete();

        return response()->json([
            'success' => (bool)$customer,
            'message' => $customer ? 'Customer deleted successfully.' : 'Failed to delete Customer.',
        ]);
    }
}
