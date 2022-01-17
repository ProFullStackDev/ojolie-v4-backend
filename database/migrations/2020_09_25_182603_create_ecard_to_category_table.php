<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcardToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecard_to_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ecard_category_id');
            $table->unsignedBigInteger('ecard_id');
            $table->tinyInteger('type');
            $table->integer('sort')->nullable();
            $table->timestamps();
        });

        Schema::table('ecard_to_category',function(Blueprint $table){
            $table->foreign('ecard_category_id')->references('id')->on('ecard_categories')->onDelete('cascade');
            $table->foreign('ecard_id')->references('id')->on('ecards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecard_to_category');
    }
}
