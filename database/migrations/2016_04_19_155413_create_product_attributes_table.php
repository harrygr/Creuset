<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('property');
            $table->string('property_slug')->index();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->unique(['slug', 'property_slug']);
        });

        Schema::create('product_product_attribute', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('product_attribute_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_attributes');
        Schema::drop('product_product_attribute');
    }
}
