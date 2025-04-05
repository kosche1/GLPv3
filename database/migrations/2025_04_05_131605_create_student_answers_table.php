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
        // Skip if the table doesn't exist
        if (!Schema::hasTable('student_answers')) {
            return;
        }

        // Make sure these columns exist
        Schema::table('student_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_answers', 'output')) {
                $table->text('output')->nullable();
            }

            if (!Schema::hasColumn('student_answers', 'status')) {
                $table->string('status')->default('submitted');
            }

            if (!Schema::hasColumn('student_answers', 'is_correct')) {
                $table->boolean('is_correct')->default(false);
            }

            if (!Schema::hasColumn('student_answers', 'score')) {
                $table->integer('score')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to do anything in down() as we're just ensuring columns exist
    }
};
