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


    // fetch
    public function fetch($id)
    {
        $service = Service::find($id);
        return response()->json($service);
    }


    public function create(Request $request)
    {
        try {



            Service::create([
                'name' => $request->name,
                'keyword' => $request->keyword,
                'type' => $request->type,
                'mode' => $request->mode,
                'validity' => $request->validity,
                'amount' => $request->amount,
                'redirect_url' => $request->redirect_url,
            ]);

            return redirect()->back()->with('success', 'Service created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the service: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $service = Service::find($request->id);
            if (!$service) {
                return redirect()->back()->with('error', 'Service not found.');
            }

            $service->update([
                'name' => $request->name,
                'keyword' => $request->keyword,
                'type' => $request->type,
                'mode' => $request->mode,
                'validity' => $request->validity,
                'amount' => $request->amount,
                'redirect_url' => $request->redirect_url,
            ]);

            return redirect()->back()->with('success', 'Service updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the service: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return response()->json(['error' => 'Service not found.'], 404);
            }

            $service->delete();
            return response()->json(['success' => 'Service deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the service: ' . $e->getMessage()], 500);
        }
    }
}
