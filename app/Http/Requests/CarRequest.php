<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch($this->method())
        {
            case "GET":
            case "DELETE":
            {
                return [];
            }
            case "POST":
            {
                return [
                    "files" => "required",
                    "car_group_id" => "required",
                    "car_mark_id" => "required",
                    "car_model_id" => "required",
                    "name" => "required|unique:cars,name",
                    "type" => "required",
                    "import_year" => "required",
                    "import_month" => "required",
                    "made_in_year" => "required",
                    "driver_hand" => "required",
                    "engine_capacity" => "required",
                    "hutlugch" => "required",
                    "running_km" => "required",
                    "hrop" => "required",
                    "fuel" => "required",
                    "price" => "required",
                    "phone" => "required",
                    "seller" => "required"
                ];
            }
            case "PUT":
            case "PATCH":
            {
                return [
                    "car_group_id" => "required",
                    "car_mark_id" => "required",
                    "car_model_id" => "required",
                    "name" => "required|unique:cars,name,".$this->getSegmentFromEnd().',id',
                    "type" => "required",
                    "import_year" => "required",
                    "import_month" => "required",
                    "made_in_year" => "required",
                    "driver_hand" => "required",
                    "engine_capacity" => "required",
                    "hutlugch" => "required",
                    "running_km" => "required",
                    "hrop" => "required",
                    "fuel" => "required",
                    "price" => "required",
                    "phone" => "required",
                    "seller" => "required"
                ];
            }
            default: break;
        }
    }

    public function messages()
    {
        return [
            "files.required" => "Зургаа оруулна уу",
            "car_group_id.required" => "Бүлэгээ сонгон уу",
            "car_mark_id.required" => "Үйлдвэрлэгчээ сонгон уу",
            "car_model_id.required" => "Загвараа сонгон уу",
            "name.required" => "Нэрээ оруулна уу",
            "type.required" => "Төрөлөө сонгоно уу",
            "import_year.required" => "Орж ирсэн оноо оруулна уу",
            "import_month.required" => "Орж ирсэн сараа оруулна уу",
            "made_in_year.required" => "Үйлдвэрлэсэн оноо оруулна уу",
            "driver_hand.required" => "Жолооны хүрдээ сонгоно уу",
            "engine_capacity.required" => "Хөдөлгүүрийн багтаамжаа оруулна уу",
            "hutlugch.required" => "Хөтлөгчөө сонгоно уу",
            "running_km.required" => "Гүйлт оруулна уу",
            "hrop.required" => "Хроп сонгоно уу",
            "fuel.required" => "Моторын төрөл сонгоно уу",
            "price.required" => "Үнээ оруулна уу",
            "phone.required" => "Утасаа оруулна уу",
            "seller.required" => "Борлуулагчаа оруулна уу"
        ];
    }

    private function getSegmentFromEnd($position_from_end = 1) {
        $segments = $this->segments();
        return $segments[sizeof($segments) - $position_from_end];
    }
}
