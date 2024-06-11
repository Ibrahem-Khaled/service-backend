<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index($subCategoryId)
    {
        try {
            $subCategory = SubCategory::with('providers')->findOrFail($subCategoryId);

            return response()->json([
                'success' => true,
                'data' => $subCategory
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
