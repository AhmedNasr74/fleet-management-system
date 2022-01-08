<?php

namespace App\Http\Resources\Bus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->resource->id,
            'available_seats_number' => $this->resource->available_seats_number,
            $this->mergeWhen(collect($this->resource)->has('seats'), [
                'seats' => BusSeatResource::collection($this->resource->seats)
            ]),

        ];
    }
}
