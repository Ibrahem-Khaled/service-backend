<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        $providers = User::where('type', 'provider')->get();
        return view('/admin/gallery', compact('galleries', 'providers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required',
        ]);
        $gallery = new Gallery();
        $gallery->user_id = $request->user_id;
        $gallery->image = $request->image;
        $gallery->save();
        toastr()->success('تم الحفظ بنجاح ');
        return back();
    }



    public function delete(Request $request, int $ga)
    {
        Gallery::findOrFail($ga)->delete();
        toastr()->success('تم حذف البيانات ');
        return back();
    }
}
