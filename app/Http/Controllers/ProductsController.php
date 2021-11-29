<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Resources\ProductsResources;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $user_id = $request->user_id;
        $status = $request->status;
        if ($status == 'O') {
            return Products::select('*')->where('status', 'O')->where('user_id', $user_id)->where('product_status', 'Available')->offset($offset)->limit($limit)->get();
        } else if ($status == 'V') {
            return Products::select('*')->where('status', 'V')->where('user_id', $user_id)->where('product_status', 'Archive')->orwhere('product_status', 'Out Of Stocks')->offset($offset)->limit($limit)->get();
        } else {
            return Products::select('*')->where('user_id', $user_id)->offset($offset)->limit($limit)->get();
        }
        // return Products::select('*')->where('status', 'V')->get();

        // return ProductsResource::collection($products);
    }

    public function indexAdmin(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $user_id = $request->user_id;
        $status = $request->status;
        if ($status == 'O') {
            return Products::select('*')->where('status', 'O')->where('id', '!=', $user_id)->where('product_status', 'Available')->offset($offset)->limit($limit)->get();
        } else if ($status == 'V') {
            return Products::select('*')->where('status', 'V')->where('id', '!=', $user_id)->where('product_status', 'Archive')->orwhere('product_status', 'Out Of Stocks')->offset($offset)->limit($limit)->get();
        } else {
            return Products::select('*')->where('id', '!=', $user_id)->offset($offset)->limit($limit)->get();
        }
    }

    public function all(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        return Products::select('*')->where('status', 'O')->where('product_status', 'Available')->orwhere('product_status', 'Out Of Stocks')->inRandomOrder()->offset($offset)->limit($limit)->get();
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
        $products->thumbnail_name = $request->input('thumbnail_name');

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
            'thumbnail_name' => $request->thumbnail_name,
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
        $file_name = time().'_'.$request->file->getClientOriginalName();
        $request->file('file')->storeAs('uploads', $file_name, 'public');

        $response = ["message" => $file_name];
        return response($response, 200);
    }

    public function show($id)
    {
        $products = Products::find($id);

        return new ProductsResources($products->loadMissing(['addresses'])->loadMissing(['product_ratings']));
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
