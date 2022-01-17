<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcardTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecard_template', function (Blueprint $table) {
            $table->id();
            $table->text('template_name');
            $table->longText('template_title');
            $table->longText('template_content');
            $table->longText('mb_template_title');
            $table->longText('mb_template_content');
            $table->unsignedBigInteger('ecard_id')->nullable();
            $table->string('default')->unique()->default(0);
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
        Schema::dropIfExists('ecard_template');
    }
}

