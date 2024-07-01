<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($provider_id)
    {
        // Find the user and load their reviews with the reviewer details
        $user = User::with(['providerReviews.user'])->findOrFail($provider_id);
    
        // Return only the reviews with the user data
        $reviews = $user->providerReviews;
    
        return response()->json($reviews);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Reviews::create($validated);

        return response()->json($review, 201);
    }

    public function show($id)
    {
        $review = Reviews::findOrFail($id);

        return response()->json($review);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Reviews::findOrFail($id);
        $review->update($validated);

        return response()->json($review);
    }

    public function destroy($id)
    {
        $review = Reviews::findOrFail($id);
        $review->delete();

        return response()->json(null, 204);
    }
}
