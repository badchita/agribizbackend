<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationsUser;
use App\Http\Resources\NotificationsUser as NotificationsUserResource;

class NotificationsUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status=null)
    {
        if ($status == 'O') {
            return NotificationsUser::select('*')->where('status', 'O')->get();
        } else if ($status == 'V') {
            return NotificationsUser::select('*')->where('status', 'V')->get();
        } else {
            return NotificationsUser::all();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notifications_user = $request->isMethod('put') ? NotificationsUser::findOrFail($request->id) : new NotificationsUser;

        $notifications_user->id = $request->input('id');
        $notifications_user->title = $request->input('title');
        $notifications_user->description = $request->input('description');
        $notifications_user->content = $request->input('content');
        $notifications_user->subject = $request->input('subject');
        $notifications_user->status = $request->input('status');

        if ($notifications_user->save()) {
            return new NotificationsUserResource($notifications_user);
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
        $notifications_user = NotificationsUser::findOrFail($id);

        return new NotificationsUserResource($notifications_user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notifications_user = NotificationsUser::findOrFail($id);

        if ($notifications_user->delete()) {
            return new NotificationsUserResource($notifications_user);
        }

        return null;
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return NotificationsUser::select('*')->where('title', 'LIKE', $title . '%')->get();
    }
}
