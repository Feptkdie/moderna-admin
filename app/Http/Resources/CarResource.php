<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CarImageResource;

use App\Models\CarCategory;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "images" => CarImageResource::collection($this->images),
            "group" => $this->group ? [
                "id" => $this->group->id,
                "name" => $this->group->name
            ] : null,
            "mark" => $this->mark ? [
                "id" => $this->mark->id,
                "name" => $this->mark->name
            ] : null,
            "model" => $this->model ? [
                "id" => $this->model->id,
                "name" => $this->model->name
            ] : null,
            "type" => $this->type,
            "importYear" => $this->import_year,
            "importMonth" => $this->import_month,
            "madeInYear" => $this->made_in_year,
            "engineCapacity" => $this->engine_capacity,
            "drivderHand" => $this->driver_hand,
            "runningKm" => $this->running_km,
            "hutlugch" => $this->hutlugch,
            "hrop" => $this->hrop,   
            "fuel" => $this->fuel,
            "description" => $this->description, 
            "price" => $this->price, 
            "phone" => $this->phone,
            "seller" => $this->seller  
        ];
    }
}
