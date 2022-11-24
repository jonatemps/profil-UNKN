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
            $table->string('departement1_id');
            $table->string('faculty1_id');
            $table->string('departement2_id')->nullable();
            $table->string('faculty2_id')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->boolean('submitted')->nullable();
            $table->boolean('speciale')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('faculty1_id')->references('id')->on('faculties');
            // $table->foreign('departement1_id')->references('id')->on('departements');
            // $table->foreign('faculty2_id')->references('id')->on('faculties');
            // $table->foreign('departement2_id')->references('id')->on('departements');
            // $table->foreign('promotion_id')->references('id')->on('promotions');


            $table->foreign('departement1_id')->references('codedpt')->on('tabledepartement');
            $table->foreign('faculty2_id')->references('codefac')->on('tablefaculte');
            $table->foreign('departement2_id')->references('codedpt')->on('tabledepartement');
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
