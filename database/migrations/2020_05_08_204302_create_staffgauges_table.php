<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStaffgaugesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffgauges', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('latitudegauge')->nullable();
            $table->string('longitudegauge')->nullable();
            $table->text('addressgauge')->nullable();
            $table->string('amphoe')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staffgauges');
    }
}
