<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('discussion_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('discussion_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();

            $table->foreign('discussion_id')
                  ->references('id')
                  ->on('discussions')
                  ->onDelete('cascade');
            $table->foreign('tag_id')
                  ->references('id')
                  ->on('tags')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('discussion_tag');
        Schema::drop('tags');
    }
}
