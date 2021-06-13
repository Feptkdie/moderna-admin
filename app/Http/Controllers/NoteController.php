<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\NoteCategory;

use Session;
use Storage;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all();
        return view("notes.index", compact("notes"));
    }

    public function create()
    {
        $categories = NoteCategory::all();
        return view("notes.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "category_id" => "required",
            "title" => "required|unique:notes,title",
            "image" => "nullable|image",
            "address" => "required",
            "phone" => "required"
        ]);

        $note = new Note;

        if ($request->hasFile("image")) {
            $image_path = $request->file("image")->store("notes", "s3");
            $note->image = Storage::disk("s3")->url($image_path);
        }
        
        $note->category_id = $request->category_id;
        $note->title = $request->title;
        $note->address = $request->address;
        $note->phone = $request->phone;
        $note->coord_x = "47.9199332";
        $note->coord_y = "106.9173425";
        $note->save();

        return redirect()->route("notes.index")->with("success", "Note created successfully");
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);
        $categories = NoteCategory::all();
        return view("notes.edit", compact("note", "categories"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "category_id" => "required",
            "title" => "required|unique:notes,title," . $id,
            "image" => "nullable|image",
            "address" => "required",
            "phone" => "required"
        ]);
        
        $note = Note::findOrFail($id);
        
        if ($request->hasFile("image")) {
            deleteImageForSingle($note->image);
            
            $image_path = $request->file("image")->store("notes", "s3");
            $note->image = Storage::disk("s3")->url($image_path);
        }

        $note->category_id = $request->category_id;
        $note->title = $request->title;
        $note->address = $request->address;
        $note->phone = $request->phone;
        $note->coord_x = $request->coord_x;
        $note->coord_y = $request->coord_y;
        $note->save();

        return redirect()->route("notes.index")->with("success", "Note updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $note = Note::findOrFail($id);
            $note->delete();

            Session::flash("success", "Note deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}