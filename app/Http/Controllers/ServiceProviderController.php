<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Flasher\Laravel\Facade\Flasher;
use Yajra\DataTables\Facades\DataTables;

class ServiceProviderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query = ServiceProvider::orderBy('created_at', 'desc');
            return DataTables::of($query)->make(true);
        }
        return view('service-provider');
    }


    public function fetch($id)
    {
        $serviceProvider = ServiceProvider::select()->where('id', $id)->first();

        return response()->json([
            'status'  => 'success',
            'message' => 'Service Provider updated successfully',
            'data'    => $serviceProvider
        ]);
    }



    public function update(Request $request, $id)
    {
        try {
            $serviceProvider = ServiceProvider::select()->where('id', $id)->first();
            $serviceProvider->base_url   = $request->base_url;
            $serviceProvider->app_key   = $request->app_key;
            $serviceProvider->app_secret   = $request->app_secret;
            $serviceProvider->username   = $request->username;
            $serviceProvider->mode   = $request->mode;
            $serviceProvider->password   = $request->password;
            $serviceProvider->save();
            flash('<strong>Updated!</strong> Sandbox credentials saved successfully.');
        } catch (\Throwable $th) {
            flash()->addError($th->getMessage());
        }



        return redirect()->back();
    }
}
