<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('bus_seats', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->foreignId('bus_id')->constrained('buses');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bus_seats');
    }
}
