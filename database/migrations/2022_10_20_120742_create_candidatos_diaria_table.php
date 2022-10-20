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
        Schema::create('candidatos_diaria', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("diarista_id");
            $table->foreign("diarista_id")->references("id")->on("users");

            $table->unsignedBigInteger("diaria_id");
            $table->foreign("diaria_id")->references("id")->on("diarias");

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
        Schema::dropIfExists('candidatos_diaria');
    }
};
