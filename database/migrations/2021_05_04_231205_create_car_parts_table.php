<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_car_parts', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("type")->nullable();
            $table->bigInteger("user_car_id")->unsigned();
            $table->string("purchased_at")->nullable();
            $table->string("replaced_at")->nullable();
            $table->string("replaced_item")->nullable();
            $table->text("address")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();

            $table->foreign("user_car_id")->references("id")->on("user_cars")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_car_parts');
    }
}
