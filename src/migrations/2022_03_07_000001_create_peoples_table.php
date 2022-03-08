<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('height')->nullable();
            $table->integer('mass')->nullable();
            $table->string('hair_color')->nullable();
            $table->string('eye_color')->nullable();
            $table->string('birth_year')->nullable();
            $table->enum('gender', ['none', 'male', 'female', 'n/a']);

            $table->unsignedBigInteger('planet_id')->nullable();
            $table->foreign('planet_id')->references('id')->on('planets');

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
        Schema::dropIfExists('peoples');
    }
};
