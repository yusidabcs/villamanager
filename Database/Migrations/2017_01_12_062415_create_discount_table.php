<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villamanager__discounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code');
            $table->tinyInteger('type');
            $table->bigInteger('discount');
            $table->bigInteger('total');
            $table->bigInteger('claim');
            $table->bigInteger('minimumPayment');
            $table->integer('villa_id');
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
        Schema::drop('villamanager__discounts');
    }

}
