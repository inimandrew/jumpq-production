<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->bigInteger('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('asset_type_id')->unsigned();
            $table->foreign('asset_type_id')->references('id')->on('asset_types')->onDelete('cascade');
            $table->bigInteger('payment_type_id')->unsigned();
            $table->foreign('payment_type_id')->references('id')->on('payment_type')->onDelete('cascade');
            $table->string('asset_url');
            $table->integer('amount');
            $table->string('title');
            $table->text('description');
            $table->string('url_link');
            $table->enum('status', ['0', '1'])->default('0');
            $table->enum('paid', ['0', '1'])->default('0');
            $table->enum('approved', ['0', '1','2'])->default('0');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('campaigns');
    }
}
