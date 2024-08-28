<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

//     make a request //by client user 
// /requests <-- view for admin;

// /user/requests view for user
// 	Post /request
// 	get /request/create 
// 	get /request/{id}

// /user/

// / // show possible requests to make; must be logged in 

class RequestController extends Controller
{
    //*
    public function getRequest($id): View
    {
        $request = Request::find($id);
        return view('request.request', ['request' => $request]);
    }
    //employees
    public function getActiveRequests(): View
    {
        $requests = Request::whereNotIn('status', ['completed', 'rejected'])->get();
        return view('request.requests', ['requests' => $requests]);
    }
    //users
    public function getUserRequest($id): View
    {
        $requests = Request::whereNotIn('status', ['completed', 'rejected'])->get();
        return view('request.requests', ['requests' => $requests]);
    }
}
