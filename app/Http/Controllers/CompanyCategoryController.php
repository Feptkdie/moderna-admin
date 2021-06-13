<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CompanyCategory;
use Storage;
use Session;

class CompanyCategoryController extends Controller
{
    public function index()
    {
        $categories = CompanyCategory::all();
        return view("company_categories.index", compact("categories"));
    }

    public function create()
    {
        return view("company_categories.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:company_categories,name",
            "image" => "nullable|image"
        ]);
           
        $category = new CompanyCategory; 

        if ($request->hasFile("image")) {
            $image_path = $request->file("image")->store("company-categories", "s3");
            $category->image = Storage::disk("s3")->url($image_path);
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route("company-categories.index")->with("success", "Company category created successfully");
    }

    public function edit($id)
    {
        $category = CompanyCategory::findOrFail($id);
        return view("company_categories.edit", compact("category"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|unique:company_categories,name," . $id,
            "image" => "nullable|image"
        ]);
        
        $category = CompanyCategory::findOrFail($id);

        if ($request->hasFile("image")) {
            deleteImageForSingle($category->image);
            
            $image_path = $request->file("image")->store("company-categories", "s3");
            $category->image = Storage::disk("s3")->url($image_path);
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route("company-categories.index")->with("success", "Company category updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $category = CompanyCategory::findOrFail($id);

            deleteImageForSingle($category->image);
            $category->companies()->detach();
            
            $category->delete();

            Session::flash("success", "Company category deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}
