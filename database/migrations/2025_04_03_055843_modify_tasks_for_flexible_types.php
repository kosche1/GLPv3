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
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->text('instructions'); 
            $table->string('submission_type');
            $table->string('evaluation_type');
            $table->json('evaluation_details')->nullable();
            $table->dropColumn(['type', 'completion_criteria', 'answer_key', 'expected_output', 'expected_solution']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add back the original columns
            $table->string('type'); 
            $table->text('completion_criteria')->nullable();
            $table->text('answer_key')->nullable();
            $table->text('expected_output')->nullable();
            $table->text('expected_solution')->nullable();

            // Drop the new columns
            $table->dropColumn(['instructions', 'submission_type', 'evaluation_type', 'evaluation_details']);
        });
    }
};
