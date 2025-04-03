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
        Schema::table('student_answers', function (Blueprint $table) {
            //
            $table->longText('submitted_text')->nullable();
            $table->string('submitted_file_path')->nullable();
            $table->string('submitted_url')->nullable();
            $table->json('submitted_data')->nullable();
            $table->decimal('score', 8, 2)->nullable(); 

            $table->text('feedback')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_correct')->nullable()->change();
            $table->string('status')->default('submitted')->change();
            $table->dropColumn(['student_answer', 'solution', 'output']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_answers', function (Blueprint $table) {
            // Add back original columns
            $table->text('student_answer')->nullable(); // Assuming original was nullable, adjust if needed
            $table->text('solution')->nullable(); // Assuming original was nullable
            $table->text('output')->nullable(); // Assuming original was nullable
            
            // Drop new columns
            $table->dropConstrainedForeignId('evaluated_by');
            $table->dropColumn(['submitted_text', 'submitted_file_path', 'submitted_url', 'submitted_data', 'score', 'feedback', 'evaluated_at']);

            // Revert changes to existing columns
            $table->boolean('is_correct')->nullable(false)->change(); // Revert nullable change, adjust if original was nullable
            $table->string('status')->default('pending')->change(); // Revert default value, adjust if original default was different
        });
    }
};
