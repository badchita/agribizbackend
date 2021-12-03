<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addresses;
use App\Http\Resources\AddressesResources;

class AddressesController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $user_id = $request->user_id;
        $status = $request->status;
        if ($status == 'O') {
            return Addresses::select('*')->where('status', 'O')->where('user_id', $user_id)->offset($offset)->limit($limit)->get();
        } else if ($status == 'V') {
            return Addresses::select('*')->where('status', 'V')->where('user_id', $user_id)->offset($offset)->limit($limit)->get();
        } else {
            return Addresses::select('*')->where('user_id', $user_id)->offset($offset)->limit($limit)->get();
        }
        // $addresses = Addresses::paginate(15);

        // return AddressesResource::collection($addresses);
    }

    public function indexAdmin(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $user_id = $request->user_id;
        $status = $request->status;
        if ($status == 'O') {
            return Addresses::select('*')->where('status', 'O')->where('id', '!=', $user_id)->offset($offset)->limit($limit)->get();
        } else if ($status == 'V') {
            return Addresses::select('*')->where('status', 'V')->where('id', '!=', $user_id)->offset($offset)->limit($limit)->get();
        } else {
            return Addresses::select('*')->where('id', '!=', $user_id)->offset($offset)->limit($limit)->get();
        }
    }

    public function store(Request $request)
    {
        $addresses = new Addresses;
        $addresses->street_building = $request->input('street_building');
        $addresses->barangay = $request->input('barangay');
        $addresses->city = $request->input('city');
        $addresses->province = $request->input('province');
        $addresses->shipping_fee = $request->input('shipping_fee');
        $addresses->name = $request->input('name');
        $addresses->mobile = $request->input('mobile');
        $addresses->status = 'O';
        $addresses->user_id = $request->input('user_id');
        $addresses->save();

        return null;
    }

    public function update(Request $request)
    {
        Addresses::where(['id' => $request->id])->update([
            'street_building' => $request->street_building,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'shipping_fee' => $request->shipping_fee,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);
    }

    public function archive(Request $request)
    {
        Addresses::where(['id' => $request->id])->update([
            'status' => $request->status,
        ]);
    }

    public function show($id)
    {
        $addresses = Addresses::findOrFail($id);

        return new AddressesResources($addresses);
    }

    public function destroy($id)
    {
        $addresses = Addresses::findOrFail($id);

        if ($addresses->delete()) {
            return new AddressesResources($addresses);
        }

        return null;
    }

    public function search($name, $user_id)
    {
        return Addresses::select('*')->where('city', 'LIKE', $name . '%')->where('user_id', $user_id)->get();
    }

    public function searchAll($name)
    {
        return Addresses::select('*')->where('city', 'LIKE', $name . '%')->get();
    }
}
