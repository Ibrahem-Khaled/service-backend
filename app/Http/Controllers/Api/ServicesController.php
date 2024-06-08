<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class ServicesController extends Controller
{

    public function index($serviceId)
    {
        $services = Job::find($serviceId)->with('subCategories')->get();
        return response()->json($services);
    }
}
