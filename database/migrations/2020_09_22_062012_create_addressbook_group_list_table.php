<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressbookGroupListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addressbook_group_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('addressbook_group_id');
            $table->unsignedBigInteger('addressbook_id');
            $table->timestamps();
        });

        Schema::table('addressbook_group_list',function(Blueprint $table){
            $table->foreign('addressbook_group_id')->references('id')->on('addressbook_groups')->onDelete('cascade');
            $table->foreign('addressbook_id')->references('id')->on('addressbooks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addressbook_group_list');
    }
}
