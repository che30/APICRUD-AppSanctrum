<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Log;

class ProductController extends BaseController
{
  
    public function index(): JsonResponse                         
    {  
        $products = Product::all();                                                                                             
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }
   
    public function store(Request $request): JsonResponse
    {
        Log::Info($request->input('data'));
        $input = $request->input('data')['products'];
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $product = Product::create($input);
        
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    } 

    public function show($id): JsonResponse
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $input =$request->input('data')['products'];
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
        
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }
   
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
