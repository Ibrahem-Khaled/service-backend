<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryApiController extends Controller
{
    public function store(Request $request, $provider)
{
    $request->validate([
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // تحقق من أن الملف هو صورة وله امتداد مسموح به
    ]);
    $uploadedImages = collect();
    foreach ($request->file('images') as $image) {
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); // إعطاء اسم فريد للصورة
        $image->move(public_path('images/galleries'), $imageName);
        $imagePath = 'images/galleries/' . $imageName;
       $gallery = Gallery::create([
            'image' => $imagePath,
            'provider_id' => $provider,
            
        ]);
        $uploadedImages->push($gallery);
    }

   
    return response()->json([
        'status' => 'success',
        'message' => 'Images uploaded successfully.',
        'data' => $uploadedImages->all()
    ], 200);
}
public function show($provider){
    $q=gallery::where('provider_id',$provider)->get();
    return response()->json([
        'status' => 'success',
        'gallery' => $q,
    ], 200);


}
public function delete($image){
    $q=Gallery::whereId($image)->first();
    $q->delete();
    return response()->json([
        'status' => 'success',
        'message' => 'Images deleted successfully.',
    ], 200);
}


}
