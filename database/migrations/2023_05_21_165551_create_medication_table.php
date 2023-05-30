<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('medications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('dosage');
                $table->string('frequency');
                $table->string('reason')->nullable();
                $table->string('route');
                $table->foreignUuid('medical_record_id')->references('id')->on('medical_records');
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
            Schema::dropIfExists('medications');
        }
    };
