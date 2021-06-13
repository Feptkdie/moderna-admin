<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->string("title");
            $table->string("image")->nullable();
            $table->string("address")->nullable();
            $table->string("phone")->nullable();
            $table->text("description")->nullable();
            $table->string("coord_x")->nullable();
            $table->string("coord_y")->nullable();
            $table->timestamps();

            $table->foreign("category_id")->references("id")->on("note_categories")->onDelete("set null");;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("notes");
    }
}
