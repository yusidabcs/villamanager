<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillamanagerDisableDateTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villamanager__disable_dates', function(Blueprint $table)
        {
            $table->increments('id');
            $table->date('date');
            $table->integer('villa_id');
            $table->string('reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('villamanager__disable_dates');
    }

}
