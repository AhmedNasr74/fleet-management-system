<?php

namespace App\Http\Controllers\Users\Bus;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bus\BusResource;
use App\Models\Bus;

class BusController extends Controller
{
    public function show(Bus $bus)
    {
        $bus->load('seats');
        return $this->apiResponseService->send(new BusResource($bus));
    }
}
