<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){
        $countries=Country::get();
        return view('/admin/country', compact('countries'));
        }

        public function store(Request $request)
        {
            $rules = [
                'name' => 'required|unique:countries,name',
            ];
        
            $customMessages = [
                'name.required' => 'حقل الدولة مطلوب.',
                'name.unique' => 'هذه الدولة موجود بالفعل.',
            ];
        
            $request->validate( $rules, $customMessages);
         
            $location = Country::create([
                'name' => $request->name,
                
            ]);
        
            if ($location) {
                toastr()->success('تم حفظ البيانات بنجاح');
                return back();
            } else {
                toastr()->error('يوجد مشكل حاليا، حاول مرة أخرى');
                return back();
            }
        }
        
        public function update(Request $request, int $co)
        {
            $rules = [
                'name' => 'required',
            ];
        
            $customMessages = [
                'name.required' => 'حقل الدولة مطلوب.',
            ];
        
            $request->validate( $rules, $customMessages);
        
            $location = Country::findOrFail($co)->update([
                'name' => $request->name,
            ]);

            if ($location) {
                toastr()->success('تم تحديث البيانات بنجاح');
                return back();
            } else {
                toastr()->error('يوجد مشكل حاليا، حاول مرة أخرى');
                return back();
            }
        }
        
         public function delete(Request $request ,int $co){
     
            Country::findOrFail($co)->delete();       
             toastr()->success('تم حذف البيانات ');
            return back();
     
         } 
}
