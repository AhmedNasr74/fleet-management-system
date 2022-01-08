<?php

namespace App\Http\Resources\Station;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class StationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name
        ];
    }
}
