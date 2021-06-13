<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting;
use Validator;
use Storage;
use Session;

class SettingController extends Controller
{
    public function index()
    {
    	$phone = "";
    	$about = "";
        $sliders = "";

    	if (Setting::count() > 0) {
    		$setting = Setting::first();
    		$phone = $setting->phone;
    		$about = $setting->about;
            $sliders = $setting->sliders;		
    	}
    	
    	return view("settings.index", compact("phone", "about", "sliders"));
    }

    public function store(Request $request)
    {
        if ($request->hasFile("files"))
        {
            $messages = [];
            for($i=0; $i<count($request->file("files")); $i++) {
                $messages["files." . $i . ".image"] = "Зураг " . ($i+1) . " буруу байна!";
                $messages["files." . $i . ".max"] = "Зураг " . ($i+1) . " файлын хэмжээ 2mb - аас хэтэрсэн байна!";
            }

            $validator = Validator::make($request->all(), [
                "files" => "required",
                "files.*" => "image|max:2048",
            ], $messages);
                
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } 
        }
        
        $images = [];
        if ($request->hasFile("files")) {
            foreach($request->file("files") as $file)
            {
                $image_path = $file->store("home-sliders", "s3");
                $image_url = Storage::disk("s3")->url($image_path);
                array_push($images, ["url" => $image_url]);
            }
        }

    	$request->validate([
    		"phone" => "required",
    		"about" => "required"
    	]);

    	if (Setting::count() == 0) {
    		$setting = new Setting;
	    	$setting->about = $request->about;
	    	$setting->phone = $request->phone;
            $setting->sliders = json_encode($images);
	    	$setting->save();
    	} else {
    		$setting = Setting::first();

    		if (!empty($request->about)) {
	            $data = convertBase64ToImageSrc($request->about, "about");
	            $about = $data->saveHTML();
	        } else {
	            $about = "";
	        }

            if ($setting->sliders && count(json_decode($setting->sliders)) > 0) {
                $images = array_merge(json_decode($setting->sliders), $images);
            } 

    		$setting->phone = $request->phone;
    		$setting->about = $about;
            $setting->sliders = json_encode($images);
    		$setting->save();
    	}
    	
    	return redirect()->route("settings")->with("success", "Successfully saved!");
    }

    public function delete_slider(Request $request)
    {
        if ($request->ajax()) {
            if ($request->url) {
                deleteImageForSingle($request->url);
                
                $setting = Setting::first();

                $new_sliders = [];
                if ($setting->sliders && count(json_decode($setting->sliders)) > 0) {
                    foreach (json_decode($setting->sliders) as $slider) {
                        if ($slider->url != $request->url) {
                            array_push($new_sliders, $slider);
                        }
                    }
                } 

                $setting->sliders = count($new_sliders) > 0 ? json_encode($new_sliders) : "";
                $setting->save();

            }

            Session::flash("success", "Slider successfully deleted");
            return response()->json(["success" => true]);    
        }
        
    }
}
