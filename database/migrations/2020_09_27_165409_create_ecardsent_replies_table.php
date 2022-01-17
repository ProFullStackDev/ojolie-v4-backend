<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcardsentRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecardsent_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ecardsent_recipient_id');
            $table->longText('message');
            $table->timestamps();
        });

        Schema::table('ecardsent_replies',function(Blueprint $table){
            $table->foreign('ecardsent_recipient_id')->references('id')->on('ecardsent_recipients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecardsent_replies');
    }
}
