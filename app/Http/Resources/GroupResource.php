<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       //return parent::toArray($request);

        return[
            "id"=>$this->id,
            "name"=>$this->name,
            "id"=>$this->id,
            "posts"=>PostResource::collection($this->hasPost),
            "users"=>$this->user_join,
            //"users"=>GroupUserResource::collection($this->whenLoaded('user_join')),
        ];
    }
}
