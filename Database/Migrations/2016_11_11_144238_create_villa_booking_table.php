<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillaBookingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villamanager__bookings', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('booking_number')->unique();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('adult_guest');
            $table->integer('child_guest');
            $table->integer('child_age');
            $table->integer('airport_transfer');
            $table->dateTime('arrival_date');
            $table->dateTime('departure_date');
            $table->string('arrival_flight_number');
            $table->string('departure_flight_number');
            $table->string('title',5);
            $table->string('first_name',20);
            $table->string('last_name',50);
            $table->string('email',50);
            $table->string('phone',50);
            $table->string('address');
            $table->string('country');
            $table->string('nationality');
            $table->bigInteger('total');
            $table->bigInteger('total_paid');
            $table->bigInteger('remaining_payment');
            $table->integer('status');
            $table->text('message');
            $table->string('log');
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
        Schema::drop('villamanager__bookings');
    }

}
