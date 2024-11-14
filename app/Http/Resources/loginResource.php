<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class loginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id"=>$this->id,
            "uid_user"=>$this->uid_user,
            "email"=>$this->email,
            "role"=>$this->role,
            "created_at"=>$this->created_at->format("Y-m-d"),
        ];
    }
}
