<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function showHome(){
        $data=Service::with(['providers' => function ($query) {
            $query->where('active', 1)->take(5); 
        }])
        ->where('active', 1)
        ->take(5) 
        ->get();
        return response()->json([
            'status' => 200,
            'homeData' => $data
        ], 200);
    }
    public function show(){
        $services = Service::select('id', 'service_name', 'jop_name', 'image', 'active')
                    ->where('active', 1)
                    ->get();
    
        return response()->json([
            'status' => 200,
            'services' => $services
        ], 200);
    }
    public function serviceDetails($service){
        $data=service::where('id',$service)->with('providers.locations')->first();
        return response()->json([
            'status' => 200,
            'service' => $data
        ], 200);



    }
    
}
