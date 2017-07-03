<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillaCategoryTranslation extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villamanager__villa_category_translations', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->integer('villa_category_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['villa_category_id', 'locale'],'id');
            $table->foreign('villa_category_id')->references('id')->on('villamanager__villa_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('villamanager__villa_category_translations');
    }

}
