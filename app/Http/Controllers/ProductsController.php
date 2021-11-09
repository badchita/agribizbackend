<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Resources\ProductsResources;

class ProductsController extends Controller
{
    public function index($user_id=null, $status=null)
    {
        if ($status == 'O') {
            return Products::select('*')->where('status', 'O')->where('user_id', $user_id)->where('product_status', 'Available')->get();
        } else if ($status == 'V') {
            return Products::select('*')->where('status', 'V')->where('user_id', $user_id)->where('product_status', 'Archive')->orwhere('product_status', 'Out Of Stocks')->get();
        } else {
            return Products::select('*')->where('user_id', $user_id)->get();
        }
        // return Products::select('*')->where('status', 'V')->get();

        // return ProductsResource::collection($products);
    }

    public function all()
    {
        return Products::select('*')->where('status', 'O')->where('product_status', 'Available')->orwhere('product_status', 'Out Of Stocks')->get();
    }

    public function store(Request $request)
    {
        $products = new Products;
        $products->name = $request->input('name');
        $products->description = $request->input('description');
        $products->price = $request->input('price');
        $products->category = $request->input('category');
        $products->quantity = $request->input('quantity');
        $products->product_status = $request->input('product_status');
        $products->product_location = $request->input('product_location');
        $products->product_location_id = $request->input('product_location_id');
        $products->status = $request->input('status');
        $products->user_id = $request->input('user_id');
        $products->save();

        return null;
    }

    public function update(Request $request)
    {
        Products::where(['id' => $request->id])->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'product_status' => $request->product_status,
            'product_location' => $request->product_location,
            'product_location_id' => $request->product_location_id,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);
    }

    public function archive(Request $request)
    {
        Products::where(['id' => $request->id])->update([
            'status' => $request->status,
            'product_status' => $request->product_status,
        ]);
    }

    public function upload(Request $request)
    {
        $imageFullName = $request->file('thumbnail_name')->getClientOriginalName();
        $request->file('thumbnail_name')->storeAs('products', $imageFullName);

        return null;
    }

    public function show($id)
    {
        $products = Products::find($id);

        return new ProductsResources($products->loadMissing(['addresses']));
    }

    public function destroy($id)
    {
        $products = Products::findOrFail($id);

        if ($products->delete()) {
            return new ProductsResources($products);
        }

        return null;
    }

    public function search($name)
    {
        return Products::select('*')->where('name', 'LIKE', $name . '%')->get();
    }
}