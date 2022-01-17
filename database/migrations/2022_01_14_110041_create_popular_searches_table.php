<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopularSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popular_searches', function (Blueprint $table) {
            $table->id();
            $table->text('keyword')->nullable();
            $table->unsignedInteger('count')->default(1);
            $table->unsignedInteger('seq')->default(1);
            $table->unsignedInteger('is_new')->default(1);
            $table->unsignedInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('popular_searches');
    }
}
