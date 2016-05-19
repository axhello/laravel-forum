<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('avatar');
            $table->string('confirm_code',64);
            $table->integer('is_confirmed')->default(0);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('nickname')->nullable();
            $table->string('weibo')->nullable();
            $table->string('github')->nullable();
            $table->string('blog')->nullable();
            $table->string('city')->nullable();
            $table->text('desc')->nullable();
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
        Schema::drop('users');
    }
}
