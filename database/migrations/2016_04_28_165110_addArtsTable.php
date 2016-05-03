<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active');
            $table->string('name');
            $table->string('artwork_url');
            $table->longText('page_content');
            $table->timestamp('publish_date');
            $table->timestamps();
        });

        Schema::create('art_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('arts')->onDelete('cascade');
            $table->integer('image_id')->unsigned();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
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
        Schema::drop('art_images');
        Schema::drop('arts');
    }
}
