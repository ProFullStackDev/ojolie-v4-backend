<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftEcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_ecards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ecard_id')->unique();
            $table->boolean('active')->default(1);
            $table->boolean('private');
            $table->boolean('popular_card')->default(0);
            $table->boolean('recommended_card')->default(0);
            $table->string('filename');
            $table->string('thumbnail');
            $table->string('caption');
            $table->text('detail');
            $table->string('video');
            $table->timestamps();
        });

        Schema::table('draft_ecards',function(Blueprint $table){
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
        Schema::dropIfExists('draft_ecards');
    }
}
