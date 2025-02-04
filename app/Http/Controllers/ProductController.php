<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'data' => $product
        ], 200);
    } 

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Product not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'data' => $product
        ], 200);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string' 
        ]);
    
        $product = Product::create($request->all());
    
        return response()->json([
            'success' => true,
            'status_code' => 201,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }
    

    public function update(Request $request, $id) {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Product not found'
            ], 404);
        }
    
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'description' => 'sometimes|nullable|string' // Tambahkan 'description'
        ]);
    
        $product->update($request->all());
    
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Product updated successfully',
            'data' => $product
         ],200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Product deleted successfully'
        ], 200);
    } 
}