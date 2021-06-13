<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = "cars";

    protected $casts = [
        "import_year" => "integer",
        "import_month" => "integer",
        "made_in_year" => "integer",
        "running_km" => "integer",
        "price" => "integer",
        "engine_capacity" => "string"
    ];

    public function group()
    {
        return $this->belongsTo(CarCategory::class, "car_group_id");
    }

    public function mark()
    {
        return $this->belongsTo(CarCategory::class, "car_mark_id");
    }

    public function model()
    {
        return $this->belongsTo(CarCategory::class, "car_model_id");
    }

    public function images()
    {
        return $this->hasMany(CarImage::class, "car_id");
    }
}
