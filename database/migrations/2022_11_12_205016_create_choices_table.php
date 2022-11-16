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
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('departement1_id');
            $table->unsignedBigInteger('faculty1_id');
            $table->unsignedBigInteger('departement2_id')->nullable();
            $table->unsignedBigInteger('faculty2_id')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->boolean('submitted');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('faculty1_id')->references('id')->on('faculties');
            $table->foreign('departement1_id')->references('id')->on('departements');
            $table->foreign('faculty2_id')->references('id')->on('faculties');
            $table->foreign('departement2_id')->references('id')->on('departements');
            $table->foreign('promotion_id')->references('id')->on('promotions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('choices');
    }
};
