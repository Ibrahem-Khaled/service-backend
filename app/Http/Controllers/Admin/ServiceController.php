<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Job::all();
        return view('admin.job', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request);
        }

        $job = Job::create($data);

        if ($job) {
            toastr()->success('Service saved successfully');
        } else {
            toastr()->error('Failed to save the service');
        }

        return back();
    }

    public function update(Request $request, int $sr)
    {
        $service = Job::findOrFail($sr);

        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('jobs')->ignore($sr), 'max:100'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service->name = $validatedData['name'];

        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->uploadImage($request);
            if ($service->image) {
                $this->deleteImage($service->image);
            }
            $service->image = $validatedData['image'];
        }

        if ($service->save()) {
            toastr()->success('Data updated successfully');
        } else {
            toastr()->error('There was an error updating the data. Please try again.');
        }

        return back();
    }

    public function delete(Request $request, int $sr)
    {
        $service = Job::findOrFail($sr);

        if ($service->image) {
            $this->deleteImage($service->image);
        }

        $service->delete();
        toastr()->success('Data deleted successfully');
        return back();
    }

    private function uploadImage($request)
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('images');
        $image->move($destinationPath, $imageName);
        return 'images/' . $imageName;
    }

    private function deleteImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}