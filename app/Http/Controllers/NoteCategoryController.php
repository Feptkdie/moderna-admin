<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NoteCategory;
use Storage;
use Session;

class NoteCategoryController extends Controller
{
    public function index()
    {
        $categories = NoteCategory::all();
        return view("note_categories.index", compact("categories"));
    }

    public function create()
    {
        return view("note_categories.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:note_categories,name",
            "image" => "nullable|image"
        ]);
           
        $category = new NoteCategory; 

        if ($request->hasFile("image")) {
            $image_path = $request->file("image")->store("note-categories", "s3");
            $category->image = Storage::disk("s3")->url($image_path);
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route("note-categories.index")->with("success", "Sos category created successfully");
    }

    public function edit($id)
    {
        $category = NoteCategory::findOrFail($id);
        return view("note_categories.edit", compact("category"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|unique:note_categories,name," . $id,
            "image" => "nullable|image"
        ]);
        
        $category = NoteCategory::findOrFail($id);

        if ($request->hasFile("image")) {
            deleteImageForSingle($category->image);
            
            $image_path = $request->file("image")->store("note-categories", "s3");
            $category->image = Storage::disk("s3")->url($image_path);
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route("note-categories.index")->with("success", "Sos category updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $category = NoteCategory::findOrFail($id);

            deleteImageForSingle($category->image);
            $category->delete();

            Session::flash("success", "Sos category deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}