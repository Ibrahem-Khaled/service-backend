<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function show(){
        $providers = Provider::select('*')
                    ->with('services','locations')
                    ->whereHas('services')
                    ->where('active', 1)
                    ->get();
    
        return response()->json([
            'status' => 200,
            'providers' => $providers
        ], 200);
    }
    public function providerDetails($provider){
        $data=Provider::where('id',$provider)
        ->where('active', 1)
        ->with('services','locations')
        ->first();
        return response()->json([
            'status' => 200,
            'provider' => $data
        ], 200);



    }
    
}
