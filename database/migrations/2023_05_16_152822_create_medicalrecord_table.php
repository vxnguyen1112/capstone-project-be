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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('symptoms');
            $table->string('previous_conditions')->nullable();
            $table->string('family_history')->nullable();
            $table->string('test_results')->nullable();
            $table->string('diagnosis');
            $table->string('treatment_plan')->nullable();
            $table->string('allergies')->nullable();
            $table->string('health_insurance')->nullable();
            $table->string('note')->nullable();
            $table->foreignUuid('doctor_id')->references('id')->on('doctors');
            $table->foreignUuid('patient_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('medical_records');
    }
};
