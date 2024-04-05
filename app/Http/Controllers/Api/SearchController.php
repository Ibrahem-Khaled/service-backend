<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Provider;
use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search($query)
    {
        try {
            $providers = Provider::with(['services', 'locations'])
                ->whereHas('services')
                ->where('first_name', 'like', '%' . $query . '%')
                ->get();

            $services = Service::with('providers.locations')
                ->where('active', 1)
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('service_name', 'like', '%' . $query . '%')
                        ->orWhere('jop_name', 'like', '%' . $query . '%');
                })
                ->get();

            $locations = Location::with('providers.services')
                ->where('title', 'like', '%' . $query . '%')
                ->get();

            if ($providers->isEmpty() && $services->isEmpty() && $locations->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No results found in providers, services, or locations.',
                ], 404);
            } else {
                return response()->json([
                    'status' => 'success',
                    'providers' => $providers,
                    'services' => $services,
                    'locations' => $locations,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while searching: ' . $e->getMessage(),
            ], 500);
        }
    }
}
