<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id');
            $table->date('checkin');
            $table->date('checkout');
            $table->integer('destination_id');
            $table->string('place', 500)->nullable();
            $table->json('rooms')->nullable();
            $table->integer('stars')->nullable();
            $table->string('hotel')->nullable();
            $table->string('note',1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_requests');
    }
}
