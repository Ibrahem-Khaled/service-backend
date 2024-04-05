<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function country(){
        $country = Country::select('id', 'name')
                    ->get();
        return response()->json([
            'status' => 200,
            'country' => $country
        ], 200);
    }
    public function location(){
        $location = Location::select('id', 'title','description','country_id')
                    ->get();
        return response()->json([
            'status' => 200,
            'location' => $location
        ], 200);
    }
    public function locationDetails($location){
        $data=Location::where('id',$location)->with('providers.services')->first();
        return response()->json([
            'status' => 200,
            'location' => $data
        ], 200);



    }
}
