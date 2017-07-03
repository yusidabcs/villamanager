<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillamanageFacilityTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('villamanager__facility_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');

            // Your translatable fields

            $table->integer('facility_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['facility_id', 'locale']);
            $table->foreign('facility_id')->references('id')->on('villamanager__facilities')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('villamanager__facility_translations');
	}
}
