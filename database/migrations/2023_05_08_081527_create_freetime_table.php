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
        Schema::create('free_times', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->boolean('is_active')->default(1);
            $table->foreignUuid('doctor_id')->references('id')->on('doctors');
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
        Schema::dropIfExists('free_times');
    }
};
