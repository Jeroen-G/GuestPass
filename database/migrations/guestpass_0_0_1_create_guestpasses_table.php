<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestPassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guestpasses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 10)->unique();
            $table->string('owner_model');
            $table->integer('owner_id');
            $table->string('object_model');
            $table->integer('object_id');
            $table->string('view')->nullable();
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
        Schema::dropIfExists('guestpasses');
    }
}
