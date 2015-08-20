<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
        });

        // Schema::create('role_user', function(Blueprint $table)
        // {
        //     $table->increments('id');
        //     $table->integer('user_id')->unsigned();
        //     $table->integer('role_id')->unsigned();

        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('role_user', function(Blueprint $table)
        // {
        //     $table->dropForeign('role_user_role_id_foreign');
        //     $table->dropForeign('role_user_user_id_foreign');
        // });

        Schema::drop('roles');
        //Schema::drop('role_user');
    }
}
