<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Location;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = User::where('type', 'provider')->get();
        $services = Job::all();
        $locations = Location::all();
        return view('/admin/providers', compact('providers', 'services', 'locations'));
    }
    public function users()
    {
        $providers = User::where('type', 'seeker')->get();
        return view('/admin/user', compact('providers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'username' => 'nullable|string',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'location_id' => 'nullable|exists:locations,id',
            'job_id' => 'nullable|exists:jobs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'identity_card' => 'nullable',
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'is_featured' => 'boolean',
            'type' => ['required', Rule::in(['admin', 'seeker', 'provider'])],
        ]);

        $userData = $request->except('password', 'image', 'identity_card');
        $userData['password'] = bcrypt($request->password);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $userData['image'] = 'images/' . $imageName;
        }

        if ($request->hasFile('identity_card')) {
            $identityCard = $request->file('identity_card');
            $identityCardName = time() . '_id.' . $identityCard->getClientOriginalExtension();
            $identityCard->move(public_path('identity_cards'), $identityCardName);
            $userData['identity_card'] = 'identity_cards/' . $identityCardName;
        }

        User::create($userData);

        toastr()->success('User details saved successfully');
        return back();
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'username' => 'nullable|string',
            'phone' => 'required|string|unique:users,phone,' . $id,
            'password' => 'nullable|string|min:6',
            'location_id' => 'nullable|exists:locations,id',
            'job_id' => 'nullable|exists:jobs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'identity_card' => 'nullable',
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'is_featured' => 'boolean',
            'type' => ['required', Rule::in(['admin', 'seeker', 'provider'])],
        ]);

        $user = User::findOrFail($id);
        $userData = $request->except('password', 'image', 'identity_card');

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $userData['image'] = 'images/' . $imageName;
        }

        if ($request->hasFile('identity_card')) {
            $identityCard = $request->file('identity_card');
            $identityCardName = time() . '_id.' . $identityCard->getClientOriginalExtension();
            $identityCard->move(public_path('identity_cards'), $identityCardName);
            $userData['identity_card'] = 'identity_cards/' . $identityCardName;
        }

        $user->update($userData);

        toastr()->success('User details updated successfully');
        return back();
    }



    public function destroy($id)
    {
        $provider = User::findOrFail($id);
        $provider->delete();

        toastr()->success('تم حذف البيانات بنجاح');
        return back();
    }
    public function toggleProviderStatus($providerId)
    {
        $provider = User::find($providerId);

        if (!$provider) {
            return response()->json(['message' => 'Provider not found'], 404);
        }

        $provider->status = $provider->status === 'active' ? 'inactive' : 'active';
        $provider->save();


        toastr()->success('تم تحديث الحالة بنجاح');
        return back();
    }

}
