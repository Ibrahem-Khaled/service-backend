<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Home()
    {
        try {
            $providers = User::with('jobs')->where('type', 'provider')->where('is_featured', 1)->get();
            $jobs = Job::with('subCategories')->get();

            if ($providers->isEmpty() && $jobs->isEmpty()) {
                return response()->json(['message' => 'No providers and jobs found'], 404);
            }

            // Adding has_subcategory flag to jobs
            $jobs = $jobs->map(function ($job) {
                $job->has_subcategory = $job->subCategories ? true : false;
                return $job;
            });

            $responseData = [
                'providers' => $providers->isEmpty() ? null : $providers,
                'jobs' => $jobs->isEmpty() ? null : $jobs,
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error', 'error' => $e->getMessage()], 500);
        }
    }




    public function allProviders()
    {
        try {
            $providers = User::with('jobs')->where('type', 'provider')->where('status', 'active')->get();
            if ($providers) {
                return response()->json($providers);
            } else {
                return response()->json(['message' => 'No providers found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error', 'error' => $e->getMessage()], 500);
        }
    }
    public function allServices()
    {
        try {
            $services = Job::all();

            if ($services->isNotEmpty()) {
                $services = $services->map(function ($service) {
                    $service->has_subcategory = $service->subCategories()->exists();
                    return $service;
                });

                return response()->json($services);
            } else {
                return response()->json(['message' => 'No services found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error', 'error' => $e->getMessage()], 500);
        }
    }

}
