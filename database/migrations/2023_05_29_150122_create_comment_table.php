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
            Schema::create('comments', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('content');
                $table->string('parent_id')->nullable();
                $table->foreignUuid('blog_id')->references('id')->on('blogs');
                $table->foreignUuid('account_id')->references('id')->on('accounts');
                $table->timestamps();
            });
            Schema::table('comments', function (Blueprint $table) {
                $table->foreign('parent_id')->references('id')->on('comments')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('comments');
        }
    };
