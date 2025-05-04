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
            if (!Schema::hasColumn('tasks', 'instructions')) {
                $table->text('instructions');
            }
            if (!Schema::hasColumn('tasks', 'submission_type')) {
                $table->string('submission_type');
            }
            if (!Schema::hasColumn('tasks', 'evaluation_type')) {
                $table->string('evaluation_type');
            }
            if (!Schema::hasColumn('tasks', 'evaluation_details')) {
                $table->json('evaluation_details')->nullable();
            }

            // Only drop columns if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('tasks', 'type')) {
                $columnsToDrop[] = 'type';
            }
            if (Schema::hasColumn('tasks', 'completion_criteria')) {
                $columnsToDrop[] = 'completion_criteria';
            }
            if (Schema::hasColumn('tasks', 'answer_key')) {
                $columnsToDrop[] = 'answer_key';
            }
            if (Schema::hasColumn('tasks', 'expected_output')) {
                $columnsToDrop[] = 'expected_output';
            }
            if (Schema::hasColumn('tasks', 'expected_solution')) {
                $columnsToDrop[] = 'expected_solution';
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
