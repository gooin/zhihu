<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return view('notifications.index',compact('user'));

    }
}
