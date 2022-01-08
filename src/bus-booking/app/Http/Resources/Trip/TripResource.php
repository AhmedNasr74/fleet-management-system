<?php

namespace App\Http\Resources\Trip;

use App\Http\Resources\Bus\BusResource;
use App\Http\Resources\Station\StationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @see \App\Models\Trip */
class TripResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'trip_name' => $this->resource->trip_name,
            $this->mergeWhen(collect($this->resource)->has('source_station'), [
                'source_station' => new StationResource($this->resource->source_station)
            ]),
            $this->mergeWhen(collect($this->resource)->has('destination_station'), [
                'destination_station' => new StationResource($this->resource->destination_station)
            ]),
            $this->mergeWhen(collect($this->resource)->has('stops'), [
                'stops' => StationResource::collection($this->resource->stops->pluck('station'))
            ]),
            $this->mergeWhen(collect($this->resource)->has('bus'), [
                'bus' => new BusResource($this->resource->bus)
            ]),
        ];
    }
}
