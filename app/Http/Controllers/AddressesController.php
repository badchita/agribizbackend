<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addresses;
use App\Http\Resources\Addresses as AddressesResource;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Addresses::paginate(15);

        return AddressesResource::collection($addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $addresses = $request->isMethod('put') ? Addresses::findOrFail($request->id) : new Addresses;

        $addresses->id = $request->input('id');
        $addresses->street_building = $request->input('street_building');
        $addresses->barangay = $request->input('barangay');
        $addresses->city = $request->input('city');
        $addresses->province = $request->input('province');
        $addresses->status = 'O';

        if ($addresses->save()) {
            return new AddressesResource($addresses);
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
        $addresses = Addresses::findOrFail($id);

        return new AddressesResource($addresses);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $addresses = Addresses::findOrFail($id);

        if ($addresses->delete()) {
            return new AddressesResource($addresses);
        }

        return null;
    }
}
