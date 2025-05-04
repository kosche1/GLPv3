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
            if (!Schema::hasColumn('student_answers', 'submitted_text')) {
                $table->longText('submitted_text')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'submitted_file_path')) {
                $table->string('submitted_file_path')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'submitted_url')) {
                $table->string('submitted_url')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'submitted_data')) {
                $table->json('submitted_data')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'score')) {
                $table->decimal('score', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'feedback')) {
                $table->text('feedback')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'evaluated_at')) {
                $table->timestamp('evaluated_at')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'evaluated_by')) {
                $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null');
            }

            // Only try to modify columns if they exist
            if (Schema::hasColumn('student_answers', 'is_correct')) {
                $table->boolean('is_correct')->nullable()->change();
            }
            if (Schema::hasColumn('student_answers', 'status')) {
                $table->string('status')->default('submitted')->change();
            }

            // Only try to drop columns if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('student_answers', 'student_answer')) {
                $columnsToDrop[] = 'student_answer';
            }
            if (Schema::hasColumn('student_answers', 'solution')) {
                $columnsToDrop[] = 'solution';
            }
            if (Schema::hasColumn('student_answers', 'output')) {
                $columnsToDrop[] = 'output';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
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
