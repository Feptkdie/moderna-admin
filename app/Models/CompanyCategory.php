<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    use HasFactory;

    protected $table = "company_categories";

    public function companies()
    {
        return $this->belongsToMany(Company::class, "company_has_categories", "category_id", "company_id");
    }
}
