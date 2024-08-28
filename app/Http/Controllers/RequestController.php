<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index(){
        return view('request.index');
    }
    public function create() {
        // Logic for creating a new request
        return view('request.create');
    }

}
