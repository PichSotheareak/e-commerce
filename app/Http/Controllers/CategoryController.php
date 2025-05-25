<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function fetchCategory()
    {
        $data = DB::table('category')->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function addCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',

        ]);

        try{
            $data = DB::table('category')->insert([
                'name' => $validated['name'],
                'description' => $validated['description'],
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
    public function updateCategory(Request $request)
    {
        $id = $request -> id;
        $name = $request -> name;
        $description = $request -> description;

        try {
            $data = DB::table('category')->where('id', $id)->update([
                'name' => $name,
                'description' => $description,
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

    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.'
            ]);
        }

        $category->delete();

        return response()->json([
            'success' => (bool)$category,
            'message' =>$category ? 'Category deleted successfully.' : 'Failed to delete category.',
        ]);

    }
}
