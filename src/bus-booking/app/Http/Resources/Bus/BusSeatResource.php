<?php

namespace App\Http\Resources\Bus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusSeatResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'seat_id' => $this->resource->uuid
        ];
    }
}
