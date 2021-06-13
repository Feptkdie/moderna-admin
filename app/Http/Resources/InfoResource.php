<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\InfoCategoryResource;

class InfoResource extends JsonResource
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
            "title" => $this->title,
            "subtitle" => $this->subtitle,
            "fileMode" => $this->file_mode,
            "filePath" => $this->file_path,
            "content" => $this->content,
            "createdAt" => $this->created_at,
            "categories" => InfoCategoryResource::collection($this->categories)
        ];
    }
}
