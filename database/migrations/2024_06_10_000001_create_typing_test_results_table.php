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
        // Only create the table if it doesn't exist
        if (!Schema::hasTable('typing_test_results')) {
            Schema::create('typing_test_results', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->integer('wpm')->comment('Words per minute');
                $table->integer('cpm')->comment('Characters per minute');
                $table->integer('accuracy')->comment('Accuracy percentage');
                $table->string('test_mode')->default('words')->comment('words or time');
                $table->integer('test_duration')->comment('Test duration in seconds');
                $table->integer('words_typed')->default(0);
                $table->integer('characters_typed')->default(0);
                $table->integer('errors')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typing_test_results');
    }
};
