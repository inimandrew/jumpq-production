<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_branch_id')->unsigned();
            $table->foreign('store_branch_id')->references('id')->on('stores_branches')->onDelete('cascade');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->enum('product_type', ['0', '1'])->default('0');
            $table->string('name');
            $table->string('uniqueId');
            $table->text('description');
            $table->decimal('cost_price')->nullable();
            $table->decimal('unit_price');
            $table->integer('quantity')->default('0');
            $table->integer('reorder_level')->nullable();
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
        Schema::dropIfExists('products');
    }
}
