<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('attendee_id');
            $table->tinyInteger('rating');
            $table->dateTime('creation_date');
            $table->text('comment')->nullable();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('attendee_id')->references('id')->on('attendees');
        });
        Schema::create('session_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('attendee_id');
            $table->tinyInteger('rating');
            $table->dateTime('creation_date');

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('attendee_id')->references('id')->on('attendees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_reviews');
        Schema::dropIfExists('session_reviews');
    }
}
