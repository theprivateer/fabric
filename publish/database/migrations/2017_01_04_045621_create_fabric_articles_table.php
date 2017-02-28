<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('fabric.database-prefix') . 'articles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('site_id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('url');
            $table->string('template')->default('article');
            $table->boolean('draft')->default(false);
            $table->dateTime('publish_at')->nullable();
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
        Schema::dropIfExists(config('fabric.database-prefix') . 'articles');
    }
}
