<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillamanageVillasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('villamanager__villas', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('location');
            $table->integer('area_id');
            $table->string('slug');
            $table->integer('category_id');
            $table->tinyInteger('max_person');
            $table->tinyInteger('minimum_stay');
            $table->tinyInteger('bedroom_number');
            $table->tinyInteger('approved');
            $table->tinyInteger('best_seller');
            $table->tinyInteger('featured');
            $table->integer('user_id');
            // Your fields
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
		Schema::drop('villamanager__villas');
	}
}
