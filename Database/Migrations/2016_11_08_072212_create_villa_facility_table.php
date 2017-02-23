<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillaFacilityTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villamanager__villa_facility', function(Blueprint $table)
        {
            $table->integer('villa_id')->unsigned()->nullable();
            $table->foreign('villa_id')->references('id')
                ->on('villamanager__villas')->onDelete('cascade');

            $table->integer('facility_id')->unsigned()->nullable();
            $table->foreign('facility_id')->references('id')
                ->on('villamanager__facilities')->onDelete('cascade');

            $table->boolean('status');
            $table->string('value');

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
        Schema::drop('villamanager__villa_facility');
    }

}
