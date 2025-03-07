<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\productRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();
        return response()->json(["data"=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(productRequest $request)
    {
        $input=$request->validated();
        Product::create($input);
        return response()->json(['message'=>'Product is added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Product::findOrFail($id);
        return response()->json(['data'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(productRequest $request, string $id)
    {
        $input=$request->validated();
        $product=Product::findOrFail($id);
        $product->update($input);
        return response()->json(['message'=>'Product is updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        return response()->json(['message'=>'Product is deleted successfully']);
    }

    public function showbyCategory($category)
    {
        $products= Product::where('categoyId',$category)->get()->load('category');
        return response()->json(['data By category'=>$products]);
    }

    public function search(Request $request)
    {
        $query=Product::query();
        if(request()->has('title'))
        {
            $query->where('title','like',$request->title.'%');
        }
        $products=$query->get();
        return response()->json(['data'=>$products]);
    }
}
