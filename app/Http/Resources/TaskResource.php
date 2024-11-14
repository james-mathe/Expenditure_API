<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            "id"=>$this->id,
            "name"=>$this->name,
            "archived"=>$this->archived,
            "Created_at"=>$this->created_at->format("Y-m-d")
        ];
    }
}
