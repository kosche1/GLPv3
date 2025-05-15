<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equation_drops', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('equation_drop_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equation_drop_id')->constrained()->onDelete('cascade');
            $table->string('difficulty')->default('easy'); // easy, medium, hard
            $table->json('display_elements'); // JSON array of equation elements
            $table->string('answer');
            $table->string('hint');
            $table->json('options'); // JSON array of answer options
            $table->integer('points')->default(100); // Points value for this question
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equation_drop_questions');
        Schema::dropIfExists('equation_drops');
    }
};
