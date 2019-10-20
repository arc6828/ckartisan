<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDateToFastworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fastworks', function (Blueprint $table) {
            $table->renameColumn('reserve_date','reserved_at');
            $table->renameColumn('complete_date','completed_at');
            $table->renameColumn('accept_date','paid_at');            
            $table->string('status')->nullable();
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
