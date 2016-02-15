<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('taxonomy')->default('category');
            $table->string('term');
            $table->string('slug')->index();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->unique(['taxonomy', 'term']);
            $table->unique(['taxonomy', 'slug']);
        });

        Schema::create('termables', function (Blueprint $table) {
            $table->integer('term_id')->unsigned();
            $table->morphs('termable');

            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('termables', function (Blueprint $table) {
            $table->dropForeign('termables_term_id_foreign');
        });

        Schema::drop('terms');
        Schema::drop('termables');
    }
}
