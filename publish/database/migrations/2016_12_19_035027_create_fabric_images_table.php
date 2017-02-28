<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('fabric.database-prefix') . 'images', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('site_id');
            $table->string('file_name');
            $table->string('original_name');
            $table->string('file_type')->nullable()->default(null);
            $table->double('size')->default(0);
            $table->integer('width')->unsigned()->default(0);
            $table->integer('height')->unsigned()->default(0);
            $table->text('exif')->nullable()->default(null);
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
        Schema::dropIfExists(config('fabric.database-prefix') . 'images');
    }
}
