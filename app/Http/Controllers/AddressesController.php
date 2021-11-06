<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addresses;
use App\Http\Resources\AddressesResources;

class AddressesController extends Controller
{
    public function index($user_id=null, $status=null)
    {
        if ($status == 'O') {
            return Addresses::select('*')->where('status', 'O')->where('user_id', $user_id)->get();
        } else if ($status == 'V') {
            return Addresses::select('*')->where('status', 'V')->where('user_id', $user_id)->get();
        } else {
            return Addresses::select('*')->where('user_id', $user_id)->get();
        }
        // $addresses = Addresses::paginate(15);

        // return AddressesResource::collection($addresses);
    }

    public function store(Request $request)
    {
        $addresses = new Addresses;
        $addresses->street_building = $request->input('street_building');
        $addresses->barangay = $request->input('barangay');
        $addresses->city = $request->input('city');
        $addresses->province = $request->input('province');
        $addresses->shipping_fee = $request->input('shipping_fee');
        $addresses->status = $request->input('status');
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

    public function search($name)
    {
        return Addresses::select('*')->where('city', 'LIKE', $name . '%')->get();
    }
}