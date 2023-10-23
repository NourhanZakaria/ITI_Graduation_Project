<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LawyerTimeResource;
class LawyerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);

        // return[
        //     "price"=>$this->price,
        //     "span"=>$this->span,
        //     "appointment"=>$this->lawyerTime
        // ];
    }
}
