<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Job::query()->get();
        if ($services === null) {
            throw new \RuntimeException('Failed to retrieve services');
        }
        return view('/admin/job', compact('services'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['image'] = $request->file('image')->store('services', 'public');

        if (Job::create($data)) {
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
            'name' => ['required', Rule::unique('services')->ignore($sr), 'max:100'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service->fill([
            'name' => $validatedData['name'],
            'jop_name' => $validatedData['jop_name'],
        ]);

        if ($request->hasFile('image')) {
            $service->image = $request->file('image')->store('services', 'public');
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
        Job::destroy($sr);
        toastr()->success('تم حذف البيانات ');
        return back();
    }

}
