<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripStopsTable extends Migration
{
    public function up()
    {
        Schema::create('trip_stops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('trip_id')->constrained('trips');
            $table->foreignId('station_id')->constrained('stations');
            $table->unsignedInteger('order');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trip_stops');
    }
}
