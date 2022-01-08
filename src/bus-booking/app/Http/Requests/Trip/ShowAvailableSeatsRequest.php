<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

class ShowAvailableSeatsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
            'start_station_id' => ['required', 'integer','different:end_station_id', 'exists:stations,id', //exist in stations
                'exists:trip_stops,station_id,trip_id,'.$this->get('trip_id') // belongs to selected trip
            ],
            'end_station_id' => ['required', 'integer', 'exists:stations,id' ,//exist in stations
                'exists:trip_stops,station_id,trip_id,'.$this->get('trip_id') // belongs to selected trip
            ],
        ];
    }
}
