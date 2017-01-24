<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVillaImages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villamanager__villa_images', function(Blueprint $table)
        {
            $table->integer('villa_id')->unsigned()->nullable();
            $table->foreign('villa_id')->references('id')
                ->on('villamanager__villas')->onDelete('cascade');

            $table->integer('file_id')->unsigned()->nullable();
            $table->foreign('file_id')->references('id')
                ->on('media__files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('villamanager__villa_images');
    }

}
