<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->unique();
            $table->bigInteger('payment_type_id')->unsigned();
            $table->bigInteger('payer_id');
            $table->string('payer_type');
            $table->foreign('payment_type_id')->references('id')->on('payment_type')->onDelete('cascade');
            $table->bigInteger('staff_id')->unsigned()->nullable();
            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade');
            $table->bigInteger('store_branch_id')->unsigned();
            $table->foreign('store_branch_id')->references('id')->on('stores_branches')->onDelete('cascade');
            $table->decimal('service_charge');
            $table->decimal('total');
            $table->enum('status',['0','1']);
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
        Schema::dropIfExists('cart_payments');
    }
}
