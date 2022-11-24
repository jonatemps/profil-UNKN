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
        Schema::create('faculte_promotion', function (Blueprint $table) {
            $table->id();
            $table->string('faculty_id',10);
            $table->string('promotion_id',10);
            $table->timestamps();

            $table->foreign('faculty_id')
                ->references('codefac')
                ->on('tablefaculte');

            $table->foreign('promotion_id')
                ->references('codetude')
                ->on('tableannetude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculte_promotion');
    }
};
