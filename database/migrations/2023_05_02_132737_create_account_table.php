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
            Schema::create('account', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('display_name')->nullable();
                $table->string('email');
                $table->string('avatar_url')->nullable();
                $table->string('password');
                $table->foreignUuid('role_id')->references('id')->on('role');
                $table->foreignUuid('information_id')->references('id')->on('information');
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
            Schema::dropIfExists('account');
        }
    };
