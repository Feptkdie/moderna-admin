<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyHasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_has_categories', function (Blueprint $table) {
            $table->bigInteger("company_id")->unsigned();
            $table->bigInteger("category_id")->unsigned();
            $table->primary(["company_id", "category_id"]);

            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("category_id")->references("id")->on("company_categories")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_has_categories');
    }
}
