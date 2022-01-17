<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcardCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecard_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->date('date')->nullable();
            $table->string('slug')->unique();
            $table->string('header_image')->nullable();
            $table->string('header_color');
            $table->text('header_descripion');
            $table->string('page_title');
            $table->text('page_description');
            $table->string('meta_keyword');
            $table->timestamps();
        });

        Schema::table('ecard_categories',function(Blueprint $table){
            $table->foreign('parent_id')->references('id')->on('ecard_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecard_categories');
    }
}
