<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcardsentRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecardsent_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ecardsent_item_id');
            $table->string('name');
            $table->string('email');
            $table->boolean('sent_queued')->default(0);
            $table->dateTime('sent_date')->nullable();
            $table->boolean('resent_queued')->default(0);
            $table->dateTime('resent_date')->nullable();
            $table->integer('count_view')->default(0);
            $table->timestamps();
        });

        Schema::table('ecardsent_recipients',function(Blueprint $table){
            $table->foreign('ecardsent_item_id')->references('id')->on('ecardsent_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecardsent_recipients');
    }
}
