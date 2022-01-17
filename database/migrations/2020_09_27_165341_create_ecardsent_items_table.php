<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcardsentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecardsent_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ecard_id');
            $table->longText('greeting');
            $table->longText('message');
            $table->tinyInteger('creation_platform')->default(0);
            $table->dateTime('scheduled_date')->nullable();
            $table->boolean('draft')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('ecardsent_items',function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ecardsent_items');
    }
}
