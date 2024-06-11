<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Location;
use App\Models\SubCategory;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = User::where('type', 'provider')->get();
        $services = Job::all();
        $locations = Location::all();
        $subCategories = SubCategory::all();
        return view('/admin/providers', compact('providers', 'services', 'locations', 'subCategories'));
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
            'type' => ['required', Rule::in(['admin', 'seeker', 'provider'])],
        ]);

        $userData = $request->except('password', 'image', 'identity_card');
        $userData['password'] = bcrypt($request->password);

        if ($request->hasFile('image')) {
            $userData['image'] = $this->uploadImage($request->file('image'), 'images');
        }

        if ($request->hasFile('identity_card')) {
            $userData['identity_card'] = $this->uploadImage($request->file('identity_card'), 'identity_cards');
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
            'type' => ['required', Rule::in(['admin', 'seeker', 'provider'])],
        ]);

        $user = User::findOrFail($id);
        $userData = $request->except('password', 'image', 'identity_card');

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $userData['image'] = $this->uploadImage($request->file('image'), 'images');
            if ($user->image) {
                $this->deleteImage($user->image);
            }
        }

        if ($request->hasFile('identity_card')) {
            $userData['identity_card'] = $this->uploadImage($request->file('identity_card'), 'identity_cards');
            if ($user->identity_card) {
                $this->deleteImage($user->identity_card);
            }
        }

        $user->update($userData);

        toastr()->success('User details updated successfully');
        return back();
    }

    public function destroy($id)
    {
        $provider = User::findOrFail($id);

        if ($provider->image) {
            $this->deleteImage($provider->image);
        }

        if ($provider->identity_card) {
            $this->deleteImage($provider->identity_card);
        }

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

    private function uploadImage($file, $folder)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $fileName);
        return $folder . '/' . $fileName;
    }

    private function deleteImage($filePath)
    {
        $fullPath = public_path($filePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
