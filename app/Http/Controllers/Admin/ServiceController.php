<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::get();
        return view('/admin/services', compact('services'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_name' => 'required|unique:services|max:100',
            'jop_name' => 'required|unique:services|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'service_name.required' => 'The service name field is required.',
            'service_name.unique' => 'The service name has already been taken.',
            'service_name.max' => 'The service name may not be greater than :max characters.',
            'jop_name.required' => 'The jop name field is required.',
            'jop_name.unique' => 'The jop name has already been taken.',
            'jop_name.max' => 'The jop name may not be greater than :max characters.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than :max kilobytes.',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->move('services/images', $request->file('image')->getClientOriginalName());
            if (!$imagePath) {
                return back()->withInput()->withErrors(['image' => 'An error occurred while uploading the image.']);
            }
        }
    
        $service = Service::create([
            'service_name' => $validatedData['service_name'],
            'jop_name' => $validatedData['jop_name'],
            'image' => $imagePath,
        ]);
    
        if ($service) {
            toastr()->success('Data saved successfully');
            return back();
        } else {
            toastr()->error('There is a problem right now, please try again');
            return back();
        }
    }
    
    public function update(Request $request, int $sr)
    {
        $validatedData = $request->validate([
            'service_name' => [
                'required',
                Rule::unique('services')->ignore($sr),
                'max:100',
            ],
            'jop_name' => 'required|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'service_name.required' => 'The service name field is required.',
            'service_name.unique' => 'The service name has already been taken.',
            'service_name.max' => 'The service name may not be greater than :max characters.',
            'jop_name.required' => 'The jop name field is required.',
            'jop_name.max' => 'The jop name may not be greater than :max characters.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than :max kilobytes.',
        ]);
    
        $service = Service::findOrFail($sr);
        $imagePath = $service->image;
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->move('services/images', $request->file('image')->getClientOriginalName());
            if (!$imagePath) {
                return back()->withInput()->withErrors(['image' => 'An error occurred while uploading the image.']);
            }
        }
    
        $service->update([
            'service_name' => $validatedData['service_name'],
            'jop_name' => $validatedData['jop_name'],
            'image' => $imagePath,
        ]);
    
        if ($service) {
            toastr()->success('Data updated successfully');
            return back();
        } else {
            toastr()->error('There is a problem right now, please try again');
            return back();
        }
    }
    

    public function delete(Request $request, int $sr)
    {

        Service::findOrFail($sr)->delete();
        toastr()->success('تم حذف البيانات ');
        return back();
    }
    public function toggle(Service $service)
    {
        $service->active = !$service->active;
        $service->save();

        if ($service->active == 1 ) {
            toastr()->success('تم تفعيل الخدمة بنجاح');
        } else {
            toastr()->success('تم إيقاف الخدمة بنجاح');
        }
        return back();
    }
}
