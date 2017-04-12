<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomFieldsToItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('fabric.database-prefix') . 'items', function (Blueprint $table) {
            $table->string('custom')->nullable()->after('model_type');
            $table->string('external_link')->nullable()->after('model_type');
            $table->string('label')->nullable()->after('model_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('fabric.database-prefix') . 'items', function (Blueprint $table) {
            $table->dropColumn(['label', 'external_link', 'custom']);
        });
    }
}
