<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dissertations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title', 255);
            $table->string('eng_title', 255);
            $table->string('description', 255);
            $table->enum('course', ['strucni', 'diplomski', 'preddiplomski'])->default('strucni');
            $table->integer('user_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dissertations');
    }
};
