<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Info;
use App\Models\InfoCategory;
use Storage;
use Session;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::all();
        return view("infos.index", compact("infos"));
    }

    public function create()
    {
        $categories = InfoCategory::all();
        return view("infos.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $file_path_rules = $request->file_mode == "image" ? "required|image" : "required";

        $request->validate([
            "categories_id" => "required",
            "title" => "required|unique:infos,title",
            "file_mode" => "required",
            "file_path" => $file_path_rules,
            "content" => "required",
        ]);

        $info = new Info;

        if ($request->file_mode =="image" && $request->hasFile("file_path")) {
            $file_path = $request->file("file_path")->store("infos", "s3");
            $info->file_path = Storage::disk("s3")->url($file_path);
        } else {
            $info->file_path = $request->file_path;
        }

        if (!empty($request->content)) {
            $data = convertBase64ToImageSrc($request->content, "infos");
            $content = $data->saveHTML();
        } else {
            $content = "";
        }

        $info->file_mode = $request->file_mode;
        $info->title = $request->title;
        $info->subtitle = $request->subtitle;
        $info->content = $content;
        $info->save();

        if ($request->categories_id) {
            $categories_id = explode(",", $request->categories_id);
            $info->categories()->attach($categories_id);
        }

        return redirect()->route("infos.index")->with("success", "Info created successfully");
    }

    public function edit($id)
    {
        $info = Info::findOrFail($id);
        $categories = InfoCategory::all();
        return view("infos.edit", compact("info", "categories"));
    }

    public function update(Request $request, $id)
    {
        $file_path_rules = $request->file_mode == "image" ? "nullable|image" : "required";

        $request->validate([
            "categories_id" => "required",
            "title" => "required|unique:infos,title," . $id,
            "file_mode" => "required",
            "file_path" => $file_path_rules,
            "content" => "required",
        ]);
        
        $info = Info::findOrFail($id);

        if (!empty($request->content)) {
            $data = convertBase64ToImageSrc($request->content, "infos");
            $content = $data->saveHTML();
        } else {
            $content = "";
        }

        if ($request->file_mode == "image") {
            if ($request->hasFile("file_path")) {
                deleteImageForSingle($info->file_path);

                $file_path = $request->file("file_path")->store("infos", "s3");
                $info->file_path = Storage::disk("s3")->url($file_path);
            }
        } else {
            deleteImageForSingle($info->file_path);
            $info->file_path = $request->file_path;
        }

        $old_content = $info->content;
        deleteImageFromUpdateEditor($old_content, $content);

        $info->title = $request->title;
        $info->file_mode = $request->file_mode;
        $info->subtitle = $request->subtitle;
        $info->content = $content;
        $info->save();

        $categories_id = [];
        if ($request->categories_id) {
            $categories_id = explode(",", $request->categories_id);
        }

        $info->categories()->sync($categories_id);

        return redirect()->route("infos.index")->with("success", "Info updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $info = Info::findOrFail($id);

            if ($info->file_mode == "image") {
                deleteImageForSingle($info->file_path);
            }
            
            $info->categories()->detach();
            $info->delete();

            Session::flash("success", "info deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}