<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Http\Resources\DashboardResources;
use App\Models\Orders;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $user_id = $request->user_id;

        $dashboard = Dashboard::select('*')->where('user_Id', '!=', $user_id)->offset($offset)->limit($limit)->get();
        return DashboardResources::collection($dashboard->loadMissing(['orders']));
    }

    public function store(Request $request)
    {
        $dashboard = new Dashboard;
        $dashboard->user_id = $request->input('user_id');

        $dashboard->save();

        return 'dashboard save';
    }

    public function show($id)
    {
        $dashboard = Dashboard::where('user_id', $id)->first();
        return new DashboardResources($dashboard->loadMissing(['orders']));
    }
}
