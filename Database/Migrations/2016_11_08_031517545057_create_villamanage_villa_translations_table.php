<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillamanageVillaTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('villamanager__villa_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('short_description');
            $table->text('description');
            $table->text('tos');

            $table->integer('villa_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['villa_id', 'locale']);
            $table->foreign('villa_id')->references('id')->on('villamanager__villas')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('villamanager__villa_translations');
	}
}
