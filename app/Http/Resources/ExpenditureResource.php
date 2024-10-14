<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenditureResource extends JsonResource
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
            "id"=> $this->id,
            "name"=> $this->name,
            "amount"=> $this->amount.'$',
            'category_id'=> $this->category_id,
            "created_at"=> $this->created_at->format("Y-m-d"),
        ];
    }
}
