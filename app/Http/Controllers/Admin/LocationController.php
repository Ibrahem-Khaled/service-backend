<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\Country;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(){
        $locations=Location::get();
        $countries = Country::all(); 

        return view('/admin/Location', compact('locations','countries'));
        }

        public function store(Request $request)
        {
            $rules = [
                'title' => 'required|unique:locations,title',
            ];
        
            $customMessages = [
                'title.required' => 'حقل العنوان مطلوب.',
                'title.unique' => 'هذا العنوان موجود بالفعل.',
            ];
        
            $request->validate( $rules, $customMessages);
         
            $location = Location::create([
                'title' => $request->title,
                'description' => $request->description,
                'country_id' => $request->country_id,
            ]);
        
            if ($location) {
                toastr()->success('تم حفظ البيانات بنجاح');
                return back();
            } else {
                toastr()->error('يوجد مشكل حاليا، حاول مرة أخرى');
                return back();
            }
        }
        
        public function update(Request $request, int $lo)
        {
            $rules = [
                'title' => 'required',
            ];
        
            $customMessages = [
                'title.required' => 'حقل العنوان مطلوب.',
            ];
        
            $request->validate( $rules, $customMessages);
        
            $location = Location::findOrFail($lo)->update([
                'title' => $request->title,
                'description' => $request->description,

            ]);

            if ($location) {
                toastr()->success('تم تحديث البيانات بنجاح');
                return back();
            } else {
                toastr()->error('يوجد مشكل حاليا، حاول مرة أخرى');
                return back();
            }
        }
        
         public function delete(Request $request ,int $lo){
     
            Location::findOrFail($lo)->delete();       
             toastr()->success('تم حذف البيانات ');
            return back();
     
         } 
}
