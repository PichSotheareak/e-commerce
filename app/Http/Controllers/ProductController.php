<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function fetchProduct()
    {
        $data = DB::table('product')->select('*')->whereNull('deleted_at')->get();
        return response()->json($data);
    }


    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'inStock' => 'required|string|max:255',
            'category_id' => 'required|integer',
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
                $imagePath = $request->file('image')->store('images', 'public');
            }


            $data = DB::table('product')->insert([
                'name' => trim($validated['name']),
                'description' => trim($validated['description']),
                'image' => $imagePath, // nullable or string path
                'cost' => $validated['cost'],
                'price' => $validated['price'],
                'inStock' => trim($validated['inStock']),
                'category_id' => $validated['category_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => (bool) $data,
                'message' => $data ? 'Product added successfully.' : 'Failed to add product.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function updateProduct(Request $request)
    {
        $id = $request -> id;
        $name = $request -> name;
        $cost = $request -> cost;
        $price = $request -> price;
        $description = $request -> description;
        $inStock = $request -> inStock;
        $category_id = $request -> category_id;

        $imagePath = 'images/default.jpg'; // fallback
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
        try {

            $data = DB::table('product')->where('id', $id)->whereNull('deleted_at')->update([
                'name' => $name,
                'description' => $description,
                'image' => $imagePath,
                'cost' => $cost,
                'price' => $price,
                'inStock' => $inStock,
                'category_id' => $category_id,
                'updated_at' => now(),

            ]);

            return response()->json([
                'success' => (bool)$data,
                'message' => $data ? 'Product Updated successfully.' : 'Failed to Updated Product.',
            ]);

        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => 'Insert failed.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        $product->delete();

        return response()->json([
            'success' => (bool)$product,
            'message' =>$product ? 'Product deleted successfully.' : 'Failed to delete Product.',
        ]);

    }
}
