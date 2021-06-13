<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\InfoResource;
use App\Http\Resources\NoteResource;
use App\Http\Resources\CompanyCategoryResource;
use App\Http\Resources\CarResource;

use App\Models\Car;
use App\Models\Info;
use App\Models\Note;
use App\Models\NoteCategory;
use App\Models\CompanyCategory;
use App\Models\Setting;

use DB;
use Carbon\Carbon;
use Cache;
use Illuminate\Support\Facades\Redis;

class ApiController extends Controller
{
    public function categories_with_company()
    {
        $categories = CompanyCategory::all();
        $data = CompanyCategoryResource::collection($categories);
        return $data;
    }

    public function get_all_infos()
    {
        $infos = Info::with("categories")->get();
        $data = InfoResource::collection($infos);
        return $data;
        // $data = DB::table("infos")
        //     ->select(DB::raw("infos.*"))
        //     ->join("info_has_categories", "info_has_categories.info_id", "=", "infos.id")
        //     ->join("info_categories", "info_categories.id", "=", "info_has_categories.category_id")
        //     ->get()
        //     ->groupBy("id");

        // return $data;
    }

    public function get_all_sos()
    {
        // $expire = Carbon::now()->addMinutes(15);
        // $notes = Cache::remember("sos", $expire, function() {
        //     return DB::table("notes")->get();
        // });
        // return $notes;

        return DB::table("notes")->select("id", "title", "address", "phone", "coord_x as coordX", "coord_y as coordY")->get();
    }

    public function get_all_cars()
    {
        $cars = Car::with("images")->get();
        $data = CarResource::collection($cars);
        return $data;
    }
    
    public function get_data(Request $request)
    {
        // $cars = Car::with("images")->get();
        // $car_data = CarResource::collection($cars);
        
        $infos = Info::with("categories")->get();
        $info_data = InfoResource::collection($infos);
        
        // $company_categories = CompanyCategory::all();
        // $company_category_data = CompanyCategoryResource::collection($company_categories);
        
        // $note_categories = NoteCategory::with("notes")->get();
        // $notes = Note::all();

        // $settings = Setting::all();

        return response()->json([
            // "settings" => $settings,
            // "cars" => $car_data,
            "infos" => $info_data,
            // "company_categories" => $company_category_data,
            // "soss" => $notes,
            // "sos_categories" => $note_categories
        ]);
    }
}
