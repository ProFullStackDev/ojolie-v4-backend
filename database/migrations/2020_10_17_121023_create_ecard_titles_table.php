<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcardTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecard_titles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ecard_id');
            $table->text('title');
            $table->timestamps();
        });

        Schema::table('ecard_titles',function(Blueprint $table){
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
        Schema::dropIfExists('ecard_titles');
    }
}
