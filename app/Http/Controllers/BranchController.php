<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function fetchBranch()
    {
        $data = DB::table('branch')->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addBranch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:branch,phone',
            'location' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try{

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            $data = DB::table('branch')->insert([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'location' => $validated['location'],
                'logo' => $logoPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => (bool) $data,
                'message' => $data ? 'User added successfully.' : 'Failed to add user.',
            ]);
        }catch (\Exception $exception ){
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function updateBranch(Request $request)
    {
        $id = $request -> id;
        $name = $request -> name;
        $phone = $request -> phone;
        $location = $request -> location;
        $logo = $request -> logo;

        try {
            $data = DB::table('branch')->where('id', $id)->update([
                'name' => $name,
                'phone' => $phone,
                'location' => $location,
                'logo' => $logo,
            ]);

            return response()->json([
                'success' => (bool)$data,
                'message' => $data ? 'User Updated successfully.' : 'Failed to Updated user.',
            ]);

        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function deleteBranch(Request $request)
    {
        $branch = Branch::find($request->id);

        if (!$branch) {
            return response()->json([
                'success' => false,
                'message' => 'Branch not found.'
            ]);
        }

        $branch->delete();

        return response()->json([
            'success' => (bool)$branch,
            'message' => $branch ? 'User deleted successfully.' : 'Failed to delete user.',
        ]);

    }
}
