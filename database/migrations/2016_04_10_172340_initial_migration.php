<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('admin');
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos');
            $table->boolean('is_root');
            $table->boolean('is_active');
            $table->string('name');
            $table->string('header');
            $table->string('meta_tags');
            $table->string('meta_description');
            $table->string('url');
            $table->integer('parent');
            $table->integer('real_level');
            $table->longText('page_content');
            $table->boolean('is_in_menu');
            $table->integer('view')
                ->references('id')
                ->on('actions')
                ->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('page_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('pos');
            $table->string('ext');
            $table->string('mime');
            $table->string('name');
            $table->integer('width');
            $table->integer('height');
            $table->integer('size');
            $table->binary('content');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
        });
        DB::statement('ALTER TABLE page_images CHANGE content content LONGBLOB');

        Schema::create('page_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
            $table->integer('pos');
            $table->string('ext');
            $table->string('mime');
            $table->string('name');
            $table->string('original_name');
            $table->integer('size');
            $table->binary('content');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE page_files CHANGE content content LONGBLOB');

        Schema::create('page_trees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos');
            $table->integer('ancestor')->unsigned();
            $table->integer('descendant');
            $table->integer('depth');
            $table->timestamps();
            $table->foreign('ancestor')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->string('url');
            $table->boolean('multiple');
            $table->timestamps();
        });

        Schema::create('views', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos');
            $table->string('name', 50);
            $table->string('view', 50);
            $table->timestamps();
        });

        Schema::create('texts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos');
            $table->string('name', 50);
            $table->string('code', 50);
            $table->string('text_content', 250);
            $table->boolean('html');
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('short', 250);
            $table->text('full');
            $table->date('date');
            $table->boolean('hot');
            $table->string('newsitem_url');
            $table->timestamps();
        });

        Schema::create('news_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('news')->onDelete('cascade');
            $table->integer('pos');
            $table->string('ext');
            $table->string('mime');
            $table->string('name');
            $table->integer('width');
            $table->integer('height');
            $table->integer('size');
            $table->binary('content');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE news_images CHANGE content content LONGBLOB');

        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('message');
            $table->text('answer');
            $table->boolean('answered');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pos');
            $table->string('ext');
            $table->string('mime');
            $table->string('name');
            $table->integer('size');
            $table->binary('content');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE files CHANGE content content LONGBLOB');

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('pos');
            $table->string('type');
            $table->text('value');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('backups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->integer('size');
            $table->string('folder');
            $table->string('sql');
            $table->string('tar');
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
        Schema::table('users', function($table) {
            $table->dropColumn('admin');
        });
        Schema::drop('page_images');
        Schema::drop('page_files');
        Schema::drop('page_trees');
        Schema::drop('pages');
        Schema::drop('actions');
        Schema::drop('views');
        Schema::drop('texts');
        Schema::drop('news_images');
        Schema::drop('news');
        Schema::drop('faqs');
        Schema::drop('files');
        Schema::drop('settings');
        Schema::drop('backups');
    }
}
