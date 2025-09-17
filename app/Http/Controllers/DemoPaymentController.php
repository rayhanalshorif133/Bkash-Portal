<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoPaymentController extends Controller
{
    public function index(Request $request){
        return view('demo-payment');
    }
}
