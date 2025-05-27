<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function fetchStaff()
    {
        $data = DB::table('staff')->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'current_address' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'branch_id' => 'required|integer',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $profile = asset('storage/images/no-image.png');

            if ($request->hasFile('profile')) {
                $profile = $request->file('profile')->store('images/staff', 'public');
            }

            $data = DB::table('staff')->insert([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'],
                'current_address' => $validated['current_address'],
                'position' => $validated['position'],
                'salary' => $validated['salary'],
                'branch_id' => $validated['branch_id'],
                'profile' => $profile,
                'created_at' => now(),

            ]);

            return response()->json([
                'success' => (bool)$data,
                'message' => $data ? 'Staff added successfully.' : 'Failed to add staff.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:staff,id',
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'current_address' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'branch_id' => 'required|integer',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $profile = asset('storage/images/no-image.png');
            if ($request->hasFile('qrcode')) {
                $profile = $request->file('qrcode')->store('images/staff', 'public');
            }

            $updateData = [
                'name' => $request->name,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'current_address' => $request->current_address,
                'position' => $request->position,
                'salary' => $request->salary,
                'branch_id' => $request->branch_id,
                'updated_at' => now(),
            ];

            if($profile){
                $updateData['profile'] = $profile;
            }

            $updated = DB::table('staff')
                ->where('id', $request -> id)
                ->whereNull('deleted_at')
                ->update($updateData);

            return response()->json([
                'success' => (bool)$updated,
                'message' => $updated ? 'Staff updated successfully.' : 'Failed to update staff.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteStaff(Request $request)
    {
        $staff = Staff::find($request->id);

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found.'
            ]);
        }

        $staff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff deleted successfully.'
        ]);
    }
}

