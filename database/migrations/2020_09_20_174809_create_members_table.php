<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('type');
            $table->string('country')->nullable();
            $table->string('timezone')->nullable();
            $table->date('expires_at')->nullable();
            $table->tinyInteger('notice_expires')->default(0);
            $table->boolean('notify_pickup')->default(1);
            $table->boolean('notify_sent')->default(0);
            $table->boolean('notify_reply')->default(0);
            $table->boolean('newsletter_subscribed')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('members',function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
