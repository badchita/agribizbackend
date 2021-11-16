<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Http\Resources\DashboardResources;

class DashboardController extends Controller
{
    public function index($user_id)
    {
        $dashboard = Dashboard::select('*')->where('user_id', $user_id)->get();
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
        $dashboard = Dashboard::find($id);

        return new DashboardResources($dashboard->loadMissing(['orders']));
    }
}
