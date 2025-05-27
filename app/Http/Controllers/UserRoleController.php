<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller
{
    public function fetchUserRole()
    {
        $data = DB::table("roles")->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addUserRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $data = DB::table("roles")->insert([
                'name' => $validated['name'],
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => (bool) $data,
                'message' => $data ? 'User Role added successfully.' : 'Failed to add user Role.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateUserRole(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        try {

            $data = DB::table("roles")->where('id', $id)->update([
                'name' => $name,
            ]);

            return response()->json([
                'success' => (bool)$data,
                'message' => $data ? 'User Role Updated successfully.' : 'Failed to Updated user Role .',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteUserRole(Request $request)
    {
        $users = UserRole::find($request->id);

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.'
            ]);
        }

        $users->delete();

        return response()->json([
            'success' => (bool)$users,
            'message' => $users ? 'User Role deleted successfully.' : 'Failed to delete user Role .',
        ]);
    }
}
