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
            $table->text('template_title');
            $table->longText('template_content');
            $table->text('title_font');
            $table->text('content_font');
            $table->string('title_color');
            $table->string('content_color');
            $table->string('text_align');
            $table->string('title_font_size');
            $table->string('content_font_size');
            $table->string('title_font_style');
            $table->string('content_font_style');
            $table->string('mb_title_color');
            $table->string('mb_content_color');
            $table->string('mb_text_align');
            $table->string('mb_title_font_size');
            $table->string('mb_content_font_size');
            $table->string('mb_title_font_style');
            $table->string('mb_content_font_style');
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
