<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\InfoCategory;
use Storage;
use Session;

class InfoCategoryController extends Controller
{
    public function index()
    {
        $categories = InfoCategory::all();
        return view("info_categories.index", compact("categories"));
    }

    public function create()
    {
        return view("info_categories.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:info_categories,name",
            "image" => "nullable|image"
        ]);
           
        $category = new InfoCategory; 

        if ($request->hasFile("image")) {
            $image_path = $request->file("image")->store("info-categories", "s3");
            $category->image = Storage::disk("s3")->url($image_path);
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route("info-categories.index")->with("success", "Info category created successfully");
    }

    public function edit($id)
    {
        $category = InfoCategory::findOrFail($id);
        return view("info_categories.edit", compact("category"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|unique:info_categories,name," . $id,
            "image" => "nullable|image"
        ]);
        
        $category = InfoCategory::findOrFail($id);

        if ($request->hasFile("image")) {
            deleteImageForSingle($category->image);
            
            $image_path = $request->file("image")->store("info-categories", "s3");
            $category->image = Storage::disk("s3")->url($image_path);
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route("info-categories.index")->with("success", "Info category updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $category = InfoCategory::findOrFail($id);

            deleteImageForSingle($category->image);
            $category->infos()->detach();
            
            $category->delete();

            Session::flash("success", "Info category deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}