<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('fabric.database-prefix') . 'contents', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->morphs('parent');
            $table->string('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('body')->nullable();
            $table->unsignedInteger('image_id')->default(0);
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
        Schema::dropIfExists(config('fabric.database-prefix') . 'contents');
    }
}
