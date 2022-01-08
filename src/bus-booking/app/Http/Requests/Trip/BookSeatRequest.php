<?php

namespace App\Http\Requests\Trip;

use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookSeatRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
            'start_station_id' => ['required', 'integer', 'different:end_station_id', 'exists:stations,id', //exist in stations
                'exists:trip_stops,station_id,trip_id,' . $this->get('trip_id') // belongs to selected trip
            ],
            'end_station_id' => ['required', 'integer', 'exists:stations,id',//exist in stations
                'exists:trip_stops,station_id,trip_id,' . $this->get('trip_id') // belongs to selected trip
            ],
            'seat_id' => ['required', 'string', Rule::exists('bus_seats', 'uuid')
                ->where('bus_id' , Trip::find($this->get('trip_id'))->bus_id)]
        ];
    }
}
