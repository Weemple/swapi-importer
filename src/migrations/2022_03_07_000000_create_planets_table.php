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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('rotation_period')->nullable();
            $table->integer('orbital_period')->nullable();
            $table->integer('diameter')->nullable();
            $table->string('climate')->nullable();
            $table->string('gravity')->nullable();
            $table->string('terrain')->nullable();
            $table->integer('surface_water')->nullable();
            $table->bigInteger('population')->nullable();

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
        Schema::dropIfExists('planets');
    }
};
