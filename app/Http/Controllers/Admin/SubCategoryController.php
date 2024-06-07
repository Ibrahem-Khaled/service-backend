<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::all();
        $services = Job::all();
        return view('admin.subCategory', compact('subCategories', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_id' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('subCategories', 'public');
        }

        SubCategory::create($data);

        return redirect()->back()->with('success', 'Sub Category created successfully.');
    }


    public function update(Request $request, SubCategory $subCategory)
    {
        $validatedData = $request->validate([
            'job_id' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->uploadImage($request);
        }

        $subCategory->update($validatedData);

        return redirect()->back()->with('success', 'Sub Category updated successfully.');
    }

    private function uploadImage($request)
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        return 'images/' . $imageName;
    }

    public function destroy($subcategoryId)
    {
        $subcategory = SubCategory::find($subcategoryId);
        $subcategory->delete();
        return redirect()->back()->with('success', 'Sub Category deleted successfully.');
    }
}
