<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query = Service::orderBy('created_at', 'desc');
            return DataTables::of($query)->make(true);
        }
        return view('service');
    }
}
