<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = "companies";

    public function categories() 
    {
        return $this->belongsToMany(CompanyCategory::class, "company_has_categories", "company_id", "category_id");
    }
}
