<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname',60);
            $table->string('lastname',60);
            $table->string('email')->unique();
            $table->string('username',25)->unique();
            $table->string('password');
            $table->string('phone',20)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_image_location')->nullable();
            $table->enum('role',['0','1'])->default('1');
            $table->enum('status',['0','1','2'])->default('0');
            $table->string('api_token',60)->nullable()->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
