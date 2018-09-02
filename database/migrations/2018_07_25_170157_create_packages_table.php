<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('user_id');
            $table->string('title')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('nights');
            $table->unsignedInteger('adults');
            $table->unsignedInteger('children_count')->nullable();
            $table->unsignedInteger('number_of_destinations');
            $table->json('countries');
            $table->json('children')->nullable();
            $table->boolean('transfer')->default(false);
            $table->enum('status',['s1','s2','s3','s4','s5','s6'])->default('s1');
            $table->string('start_place')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
