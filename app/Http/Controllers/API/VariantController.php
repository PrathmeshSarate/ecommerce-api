<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants;
        if($variants->count()>0){
            return response()->json([
                'status' => 200,
                'data' => $product->variants
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Data Not Found"
            ]);
        }
    }

    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'sku' => 'required|string|unique:variants',
            'additional_cost' => 'required|numeric',
            'stock_count' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors(),
            ], 422);
        }

        $variant = $product->variants()->create($request->all());

        return response()->json([
            'message' => 'Variant created successfully',
            'data' => $variant,
        ],201);
    }

    public function show($product, $variant)
    {
        $product_fetch = Product::find($product);
        $variant_fetch = Variant::find($variant);


        if($product_fetch && $variant_fetch){
            return response()->json([
                'status' => 200,
                'data' => $variant_fetch],200);
        }else{
            return response()->json([
                "status" => 404,
                "message" => "Data Not Found"],404);
        }
    }

    public function update(Request $request, Product $product, Variant $variant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'sku' => 'required|string|unique:variants,sku,' . $variant->id, // Update validation with existing ID
            'additional_cost' => 'required|numeric',
            'stock_count' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors(),
            ], 422);
        }

        $variant->update($request->all());

        return response()->json([
            'message' => 'Variant updated successfully',
            'data' => $variant,
        ],200);
    }

    public function destroy(Product $product, Variant $variant)
    {
        $variant->delete();

        return response()->json([
            'status' => 204,
            'message' => 'Variant deleted successfully',
        ],204);
    }
}
