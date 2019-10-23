<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPricePerHourToFastworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fastworks', function (Blueprint $table) {            
            $table->float('price_per_hour')->nullable()->default(100);   
            $table->float('price')->nullable()->default(0)->change();
            $table->float('hours')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fastworks', function (Blueprint $table) {
            //
        });
    }
}
