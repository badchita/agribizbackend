<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResources;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        return new UserResources($user);
    }
}
