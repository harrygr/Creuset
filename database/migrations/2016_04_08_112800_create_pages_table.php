<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('slug')->unique();
            $table->string('status', 20)->default('published');
            $table->integer('user_id')->unsigned();
            $table->integer('page_id')->unsigned()->nullable();
            $table->integer('image_id')->unsigned()->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('pages', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function ($table) {
            $table->dropForeign('pages_user_id_foreign');
            $table->dropForeign('pages_post_id_foreign');
        });
        Schema::drop('pages');
    }
}
