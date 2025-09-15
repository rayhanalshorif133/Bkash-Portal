<?php

namespace App\Http\Controllers;

use App\Models\ServiceProviderSandbox;
use Illuminate\Http\Request;
use Flasher\Laravel\Facade\Flasher;

class ServiceProviderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $serviceProviderSandbox = ServiceProviderSandbox::first();

        return view('service-provider', compact('serviceProviderSandbox'));
    }

    public function update(Request $request, $type = "production")
    {
        try {
            if ($type == "sandbox") {
                $serviceProviderSandbox = ServiceProviderSandbox::first();
                $serviceProviderSandbox->base_url   = $request->base_url;
                $serviceProviderSandbox->app_key   = $request->app_key;
                $serviceProviderSandbox->app_secret   = $request->app_secret;
                $serviceProviderSandbox->username   = $request->username;
                $serviceProviderSandbox->username   = $request->username;
                $serviceProviderSandbox->password   = $request->password;
                $serviceProviderSandbox->save();
            } else {
                dd($type);
            }
            flash('<strong>Updated!</strong> Sandbox credentials saved successfully.');
        } catch (\Throwable $th) {
            flash()->addError($th->getMessage());
        }



        return redirect()->back();
    }
}
