<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\CompanyCategory;

use Storage;
use Session;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view("companies.index", compact("companies"));
    }

    public function create()
    {
        $categories = CompanyCategory::all();
        return view("companies.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "categories_id" => "required",
            "name" => "required|unique:companies,name",
            "logo" => "nullable|image"
        ]);
        
        $company = new Company; 

        if ($request->hasFile("logo")) {
            $logo_path = $request->file("logo")->store("companies", "s3");
            $company->logo = Storage::disk("s3")->url($logo_path);
        }

        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->coord_x = "47.9199332";
        $company->coord_y = "106.9173425";
        $company->save();

        if ($request->categories_id) {
            $categories_id = explode(",", $request->categories_id);
            $company->categories()->attach($categories_id);
        }
        
        return redirect()->route("companies.index")->with("success", "Company created successfully");
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $categories = CompanyCategory::all();
        return view("companies.edit", compact("company", "categories"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "categories_id" => "required",
            "name" => "required|unique:companies,name," . $id,
            "logo" => "nullable|image"
        ]);
        
        $company = Company::findOrFail($id);

        if ($request->hasFile("logo")) {
            deleteImageForSingle($company->logo);
            
            $logo_path = $request->file("logo")->store("companies", "s3");
            $company->logo = Storage::disk("s3")->url($logo_path);
        }

        if ($request->json_data && count(json_decode($request->json_data)) > 0) {
            $json_data = $request->json_data;
        } else {
            $json_data = "";
        }

        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->coord_x = $request->coord_x;
        $company->coord_y = $request->coord_y;
        $company->json_data = $json_data;
        
        $company->save();

        $categories_id = [];
        if ($request->categories_id) {
            $categories_id = explode(",", $request->categories_id);
        }

        $company->categories()->sync($categories_id);
        return redirect()->route("companies.index")->with("success", "Company updated successfully");
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $company = Company::findOrFail($id);
            deleteImageForSingle($company->logo);

            $company->categories()->detach();
            $company->delete();

            Session::flash("success", "Company deleted successfully");
            return response()->json(["success" => true]);
        }
    }
}
