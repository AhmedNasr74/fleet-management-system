<?php

namespace App\Http\Resources\Trip;

use App\Http\Resources\Bus\BusResource;
use App\Http\Resources\Station\StationResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TripBookingResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'seat_id' => $this->resource->seat_id,
            'user' => $this->resource->user,
            'trip' => new TripResource($this->resource->trip),
            'bus' => new BusResource($this->resource->bus),
            'source' => new StationResource($this->resource->source),
            'destination' => new StationResource($this->resource->destination),
        ];
    }
}
