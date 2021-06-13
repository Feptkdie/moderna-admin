<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCar extends Model
{
    use HasFactory;

    protected $table = "user_cars";

    public function parts()
    {
        return $this->hasMany(UserCarPart::class, "user_car_id");
    }
}
