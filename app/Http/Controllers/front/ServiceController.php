<?php

namespace App\Http\Controllers\front;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    //method will return all active services
   public function index()
    {
        // Define and fetch the services from the database
        $services = Service::all(); // or whatever query you need

        // Return the services as JSON
        return response()->json([
            'status' => true,
            'data' => $services
        ]);
    }

    //This method will return latest active services
     public function latestServices(Request $request){

       $services = Service::where('status',1)
       ->take($request->get('limit'))
       ->orderBy('created_at','DESC')->get();
       return response()->json([
        'status' => true,
        'data' => $services
       ]);

    }

    //This method will return a single service
      public function service($id)
    {
        // Define and fetch the services from the database
        $service = Service::find($id); // or whatever query you need
        if($service == null){
            return response()->json([
                'status' => false,
                'message' => 'Service not found'
            ]);
        }
        // Return the services as JSON
        return response()->json([
            'status' => true,
            'data' => $service
        ]);
    }
}
