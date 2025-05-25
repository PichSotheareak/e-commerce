<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function fetchUser()
    {
        $data = DB::table("users")->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'gender' => 'required|string',
            'role_id' => 'string|nullable',
        ]);

        try {
            $data = DB::table("users")->insert([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'password' => bcrypt($validated['password']),
                'role_id' => $validated['role_id'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => (bool) $data,
                'message' => $data ? 'User added successfully.' : 'Failed to add user.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateUser(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $password = $request->password;
        $role_id = $request->role_id;

        try {

            $data = DB::table("users")->where('id', $id)->update([
                'name' => $name,
                'email' => $email,
                'gender' => $gender,
                'password' => Hash::make('password'),
                'role_id' => $role_id,
            ]);

            return response()->json([
                'success' => (bool)$data,
                'message' => $data ? 'User Updated successfully.' : 'Failed to Updated user.',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteUser(Request $request)
    {
        $users = User::find($request->id);

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'Branch not found.'
            ]);
        }

        $users->delete();

        return response()->json([
            'success' => (bool)$users,
            'message' => $users ? 'User deleted successfully.' : 'Failed to delete user.',
        ]);
    }
}
