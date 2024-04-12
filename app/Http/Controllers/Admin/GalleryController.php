<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){
        $galleries=Gallery::all();
        return view('/admin/gallery', compact('galleries'));
    }
    public function delete(Request $request ,int $ga){
        Gallery::findOrFail($ga)->delete();       
         toastr()->success('تم حذف البيانات ');
        return back();
     } 
}
