<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Http\Requests\CarRequest;

use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarImage;

use Storage;
use Session;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view("cars.index", compact("cars"));
    }

    public function create()
    {
        $categories = CarCategory::whereNull("category_id")
            ->with("childrenCategories")
            ->get();
        return view("cars.create", compact("categories"));
    }

    public function store(CarRequest $request)
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
                $image_path = $file->store("cars", "s3");
                $image_url = Storage::disk("s3")->url($image_path);
                array_push($images, ["url" => $image_url]);
            }
        }

        $car = new Car;
        $car->car_group_id = $request->car_group_id;
        $car->car_mark_id = $request->car_mark_id;
        $car->car_model_id = $request->car_model_id;
        $car->name = $request->name;
        $car->type = $request->type;
        $car->import_year = $request->import_year;
        $car->import_month = $request->import_month;
        $car->made_in_year = $request->made_in_year;
        $car->driver_hand = $request->driver_hand;
        $car->engine_capacity = $request->engine_capacity;
        $car->hutlugch = $request->hutlugch;
        $car->running_km = $request->running_km;
        $car->hrop = $request->hrop;
        $car->fuel = $request->fuel;
        $car->description = $request->description;
        $car->price = $request->price;
        $car->phone = $request->phone;
        $car->seller = $request->seller;
        $car->save();

        $car->images()->createMany($images);

        return redirect()->route("cars.index")->with("success", "Шинэ машины мэдээлэл бүртгэгдлээ");
    }

    public function edit($id)
    {
        $categories = CarCategory::whereNull("category_id")
            ->with("childrenCategories")
            ->get();
        $car = Car::findOrFail($id);
        return view("cars.edit", compact("car", "categories"));
    }

    public function update(CarRequest $request, $id)
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
                $image_path = $file->store("cars", "s3");
                $image_url = Storage::disk("s3")->url($image_path);
                array_push($images, ["url" => $image_url]);
            }
        }

        $request->validate([
            "name" => "required"
        ]);

        $car = Car::findOrFail($id);
        $car->car_group_id = $request->car_group_id;
        $car->car_mark_id = $request->car_mark_id;
        $car->car_model_id = $request->car_model_id;
        $car->name = $request->name;
        $car->type = $request->type;
        $car->import_year = $request->import_year;
        $car->import_month = $request->import_month;
        $car->made_in_year = $request->made_in_year;
        $car->driver_hand = $request->driver_hand;
        $car->engine_capacity = $request->engine_capacity;
        $car->hutlugch = $request->hutlugch;
        $car->running_km = $request->running_km;
        $car->hrop = $request->hrop;
        $car->fuel = $request->fuel;
        $car->description = $request->description;
        $car->price = $request->price;
        $car->phone = $request->phone;
        $car->seller = $request->seller;
        $car->save();

        if (count($images) > 0) {
            $car->images()->createMany($images);
        }
        
        return redirect()->route("cars.index")->with("success", "Машины мэдээлэл амжилттай засагдлаа");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $car = Car::findOrFail($id);
            
            $images = $car->images;
            foreach($images as $image) {
                deleteImageForSingle($image->url);
            }

            $car->images()->delete();
            $car->delete();

            Session::flash("success", "Машины мэдээлэл устгагдлаа");
            return response()->json(["success" => true]);
        }
    }

    public function delete_image(Request $request, $id)
    {
        if ($request->ajax()) {
            $carImage = CarImage::findOrFail($id);
            deleteImageForSingle($carImage->url);
            $carImage->delete();

            Session::flash("success", "Car image successfully deleted");
            return response()->json(["success" => true]);    
        }
        
    }
}
