<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('pay_via');
            $table->string('pay_via_type')->nullable();
            $table->string('pay_currency');
            $table->float('pay_amount');
            $table->datetime('pay_date');
            $table->string('pay_status');
            $table->string('pay_name')->nullable();
            $table->string('pay_email')->nullable();
            $table->string('transaction_id');
            $table->timestamps();
        });

        Schema::table('payments',function(Blueprint $table){
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
