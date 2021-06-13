<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "logo" => $this->logo,
            "phone" => $this->phone,
            "coordX" => $this->coord_x,
            "coordY" => $this->coord_y,
            "jsonData" => $this->json_data
        ];
    }
}
