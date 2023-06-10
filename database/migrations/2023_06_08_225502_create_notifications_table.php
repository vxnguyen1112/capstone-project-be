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
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('content');
                $table->string('link')->default('/');
                $table->foreignUuid('account_id')->nullable()->references('id')->on('accounts');
                $table->foreignUuid('to_account_id')->references('id')->on('accounts');
                $table->boolean('is_read')->default(0);
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
            Schema::dropIfExists('notifications');
        }
    };
