<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LawyerTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       //return parent::toArray($request);
 
        // return[
        //     "startHour"=>$this->startHour,
        //     "endHour"=>$this->endHour,
        // ];

        $lawyerTimes = [];

        foreach ($this->resource as $lawyerTime) {
            $lawyerTimes[] = [
                'startHour' => $lawyerTime->startHour,
                'endHour' => $lawyerTime->endHour,
                'day' => $lawyerTime->day,
            ];
        }

        return $lawyerTimes;
    }
}
