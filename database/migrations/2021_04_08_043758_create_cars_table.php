<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("car_group_id")->nullable();
            $table->unsignedBigInteger("car_mark_id")->nullable();
            $table->unsignedBigInteger("car_model_id")->nullable();
            $table->string("type");
            $table->integer("import_year");
            $table->integer("import_month");
            $table->integer("made_in_year");
            $table->float("engine_capacity");
            $table->string("driver_hand");
            $table->integer("running_km");
            $table->string("hutlugch");
            $table->string("hrop");
            $table->string("fuel");
            $table->text("description")->nullable();
            $table->double("price");
            $table->string("phone")->nullable();
            $table->string("seller")->nullable();
            $table->timestamps();

            $table->foreign('car_group_id')->references('id')->on('car_categories')->onDelete("set null");
            $table->foreign('car_mark_id')->references('id')->on('car_categories')->onDelete("set null");
            $table->foreign('car_model_id')->references('id')->on('car_categories')->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
