<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CarCategory;
use Storage;
use Session;

class CarCategoryController extends Controller
{
    public function index()
    {
        $categories = CarCategory::whereNull("category_id")
            ->with("childrenCategories")
            ->get();
        return view("car_categories.index", compact("categories"));
    }

    public function create()
    {
        $categories = CarCategory::whereNull("category_id")
            ->with("childrenCategories")
            ->get();
        
        return view("car_categories.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:car_categories,name"
        ]);
           
        $category = new CarCategory; 
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->save();

        return redirect()->route("car-categories.index")->with("success", "Car category created successfully");
    }

    public function edit($id)
    {
        $category = CarCategory::findOrFail($id);
        return view("car_categories.edit", compact("category"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|unique:car_categories,name," . $id
        ]);
        
        $category = CarCategory::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route("car-categories.index")->with("success", "Car category updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $category = CarCategory::findOrFail($id);
            
            $category->childrenCategories()->delete();        
            $category->delete();

            Session::flash("success", "Car category deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}
