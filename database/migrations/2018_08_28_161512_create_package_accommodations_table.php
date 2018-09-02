<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_accommodations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('country_id');
            $table->enum('accommodation_type',['hotel','apartment','none'])->default('hotel');
            $table->json('rooms')->nullable();
            $table->date('checkin');
            $table->date('checkout');
            $table->unsignedInteger('nights');
            $table->string('hotel_name')->nullable();
            $table->string('area_name')->nullable();
            $table->string('room_type')->nullable();
            $table->string('room_view')->nullable();
            $table->unsignedInteger('stars')->nullable();
            $table->text('note')->nullable();
            $table->json('other_services')->nullable();
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
        Schema::dropIfExists('package_accommodations');
    }
}
