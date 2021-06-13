<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCategory extends Model
{
    use HasFactory;

    protected $table = "car_categories";

    public function categories()
    {
       return $this->hasMany(CarCategory::class, "category_id");
    }

    public function childrenCategories()
    {
        return $this->categories()->with("childrenCategories");
    }
}
