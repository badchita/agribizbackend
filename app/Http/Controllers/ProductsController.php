<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Resources\Products as ProductsResource;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status=null)
    {
        if ($status == 'O') {
            return Products::select('*')->where('status', 'O')->get();
        } else if ($status == 'V') {
            return Products::select('*')->where('status', 'V')->get();
        } else {
            return Products::all();
        }
        // return Products::select('*')->where('status', 'V')->get();

        // return ProductsResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = $request->isMethod('put') ? Products::findOrFail($request->id) : new Products;

        $products->id = $request->input('id');
        $products->name = $request->input('name');
        $products->description = $request->input('description');
        $products->price = $request->input('price');
        $products->category = $request->input('category');
        $products->quantity = $request->input('quantity');
        $products->status = $request->input('status');
        $products->product_status = $request->input('product_status');
        $products->product_location = $request->input('product_location');
        $products->product_location_id = $request->input('product_location_id');
        $products->status = $request->input('status');

        if ($products->save()) {
            return new ProductsResource($products);
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Products::findOrFail($id);

        return new ProductsResource($products);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Products::findOrFail($id);

        if ($products->delete()) {
            return new ProductsResource($products);
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Products::select('*')->where('name', 'LIKE', $name . '%')->get();
    }
}