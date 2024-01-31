<?php
namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if($products->count()>0){

            return response()->json(['status'=>200,'data'=>$products],200);
        
        }else{
            return response()->json(['status'=>404,'message'=> "No Record Found"],404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors(),
            ], 422);
        }else{
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            if($product){
                return response()->json([ 
                    'status'=> 200,
                    'message' => "Product Added"],201);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>"Failed to Add"
                ],500);

            }
        }
    }

    public function show($product)
    {
        $product_fetch = Product::find($product);
        if($product_fetch){
            return response()->json(['status'=>200,'data'=>$product_fetch],200);
        }else{
            return response()->json(['status'=>404,'message'=>"Data Not Found"],404);
        }

    }
    
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $product->update($request->all());
    
        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $product,
        ],200);
    }
    
    public function destroy($product)
    {
        $product_fetch = Product::find($product);

        if($product_fetch){

            $product_fetch->delete();
        
            return response()->json([
                'status' => 204,
                'message' => 'Product deleted successfully',
            ],204);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Product Not found',
            ],404);
        }
    }

    
    
    public function search(Request $request)
    {
        $product_query = Product::query();
        $variant_query = Variant::query();

        if(isset($request->data)){

            $product_query->where('name','LIKE','%'. $request->data .'%')
            ->orwhere('description','LIKE','%'. $request->data .'%');

            $variant_query->where('name','LIKE','%'. $request->data .'%');
            
            if($product_query->get()->count() > 0 || $variant_query->get()->count() > 0){
            
                return response()->json([
                    'status' => 200,
                    'data' => [
                        "products" => $product_query->get(),
                        "variants" => $variant_query->get()]       
                ]);
            
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => "Data not found" 
                ]);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data required to search'
            ]);
        }


    }

}