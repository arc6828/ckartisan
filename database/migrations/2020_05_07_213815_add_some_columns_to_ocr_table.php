<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsToOcrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ocrs', function (Blueprint $table) {
            $table->string('user_id')->nullable();
            $table->text('json_line')->nullable();
            $table->string('lineid')->nullable();
            $table->text('numbers')->nullable();
            $table->string('staffgaugeid')->nullable();
            $table->string('locationid')->nullable();
            $table->string('msgocrid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ocrs', function (Blueprint $table) {
            //
        });
    }
}
