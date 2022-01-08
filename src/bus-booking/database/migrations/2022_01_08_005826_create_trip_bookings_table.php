<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('trip_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('trip_id')->constrained('trips');
            $table->foreignId('bus_id')->constrained('buses');
            $table->string('seat_id');
            $table->foreign('seat_id')->on('bus_seats')->references('uuid');
            $table->foreignId('from')->constrained('stations');
            $table->foreignId('to')->constrained('stations');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trip_bookings');
    }
}
