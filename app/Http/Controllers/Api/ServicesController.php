<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class ServicesController extends Controller
{

    public function index($serviceId)
    {
        try {
            $service = Job::with('subCategories')->findOrFail($serviceId);
            return response()->json($service);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Service not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error', 'error' => $e->getMessage()], 500);
        }
    }

    public function allProvidersFromService($serviceId)
    {
        try {
            // استخدم findOrFail للعثور على الخدمة ومعالجة الحالة إذا لم يتم العثور عليها
            $job = Job::with('users')->findOrFail($serviceId);
            return response()->json($job);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Service not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error', 'error' => $e->getMessage()], 500);
        }
    }
}
