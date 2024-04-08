<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Provider;
use App\Models\Service;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index(){
        $providers=provider::where('type',1)->get();
        $services=Service::all();
        $locations=Location::all();
        return view('/admin/providers', compact('providers','services','locations'));
        }
        public function users(){
            $providers=provider::where('type',0)->get();
            return view('/admin/user', compact('providers'));
            }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'username' => 'nullable|string',
            'phone' => 'required|string|unique:providers',
            'password' => 'required|string',
            'user_password' => 'nullable|string',
            'years_experience' => 'nullable|integer',
            'location_id' => 'nullable|exists:locations,id',
            'service_id' => 'nullable|exists:services,id',
            'active' => 'boolean',
            'avater' => 'nullable',
            'type' => 'boolean',
        ], [
            'first_name.required' => 'The first name field is required.',
            'phone.required' => 'The phone number field is required.',
            'phone.unique' => 'The phone number has already been taken.',
            'password.required' => 'The password field is required.',
            'location_id.exists' => 'The selected location is invalid.',
            'service_id.exists' => 'The selected service is invalid.',
            'active.boolean' => 'The active field must be true or false.',
            'type.boolean' => 'The type field must be true or false.',
        ]);
        $request->merge(['type' => 1]);    
        $provider = Provider::create($request->all());
    
        if ($request->has('password')) {
            $provider->password = bcrypt($request->input('password'));
            $provider->save();
        }
    
        if ($request->hasFile('avater')) {
            $avatar = $request->file('avater');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avaters'), $avatarName);
            $avatarPath = 'avaters/' . $avatarName;
            $provider->avater = $avatarPath;
            $provider->save();
        }
    
        toastr()->success('تم حفظ البيانات بنجاح');
        return back();
        }
    

        public function update(Request $request, $id)
        {
            $request->validate([
                'first_name' => 'string',
                'last_name' => 'nullable|string',
                'username' => 'nullable|string',
                'phone' => 'required|string|unique:providers,phone,' . $id,
                'password' => 'string',
                'user_password' => 'nullable|string',
                'years_experience' => 'nullable|integer',
                'location_id' => 'nullable|exists:locations,id',
                'service_id' => 'nullable|exists:services,id',
                'active' => 'boolean',
                'type' => 'boolean',
            ], [
                'first_name.string' => 'The first name must be a string.',
                'last_name.string' => 'The last name must be a string.',
                'username.string' => 'The username must be a string.',
                'phone.required' => 'The phone number field is required.',
                'phone.unique' => 'The phone number has already been taken.',
                'password.string' => 'The password must be a string.',
                'user_password.string' => 'The user password must be a string.',
                'years_experience.integer' => 'The years of experience must be an integer.',
                'location_id.exists' => 'The selected location is invalid.',
                'service_id.exists' => 'The selected service is invalid.',
                'active.boolean' => 'The active field must be true or false.',
                'type.boolean' => 'The type field must be true or false.',
            ]);        
            $provider = Provider::findOrFail($id);
            $provider->update($request->all());
            if ($request->has('password')) {
                $provider->password = bcrypt($request->input('password'));
                $provider->save();
            }
            if ($request->hasFile('avater')) {
                $avatar = $request->file('avater');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('avaters'), $avatarName);
                $avatarPath = 'avaters/' . $avatarName;
                $provider->avater = $avatarPath;
                $provider->save();
            }
            toastr()->success('تم حفظ البيانات بنجاح');
            return back();
                }
        

    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();

        toastr()->success('تم حذف البيانات بنجاح');
        return back();    
    }
public function toggleProviderStatus($providerId)
{
    $provider = Provider::find($providerId);

    if (!$provider) {
        return response()->json(['message' => 'Provider not found'], 404);
    }

    $provider->active = !$provider->active;
    $provider->save();


    toastr()->success('تم تحديث الحالة بنجاح');
    return back();  
}

}
