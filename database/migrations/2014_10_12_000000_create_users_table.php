<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname',25);
            $table->string('lastname',25);
            $table->string('email')->unique();
            $table->string('username',25)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status',['0','1','2'])->default('0');
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('birthday','15')->nullable();
            $table->string('profile_image_location')->nullable();
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
        Schema::dropIfExists('users');
    }
}
