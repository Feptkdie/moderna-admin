<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cars', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("cover")->nullable();
            $table->string("image")->nullable();
            $table->string("group_name")->nullable();
            $table->string("mark_name");
            $table->string("country_number");
            $table->string("vin_number")->nullable();
            $table->string("color")->nullable();
            $table->string("driver_hand")->nullable();
            $table->string("hrop")->nullable();
            $table->string("engine_capacity")->nullable();
            $table->string("made_in_year")->nullable();
            $table->string("import_year")->nullable();
            $table->bigInteger("user_id")->unsigned();

            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_cars');
    }
}
