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
        if (Schema::hasTable('typing_test_challenges')) {
            Schema::table('typing_test_challenges', function (Blueprint $table) {
                // Add missing columns if they don't exist
                if (!Schema::hasColumn('typing_test_challenges', 'target_wpm')) {
                    $table->integer('target_wpm')->default(30)->comment('Target words per minute');
                }
                
                if (!Schema::hasColumn('typing_test_challenges', 'target_accuracy')) {
                    $table->integer('target_accuracy')->default(85)->comment('Target accuracy percentage');
                }
                
                if (!Schema::hasColumn('typing_test_challenges', 'points_reward')) {
                    $table->integer('points_reward')->default(50);
                }
                
                if (!Schema::hasColumn('typing_test_challenges', 'created_by')) {
                    $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                }
                
                if (!Schema::hasColumn('typing_test_challenges', 'word_list')) {
                    $table->json('word_list')->nullable()->comment('Custom word list, null for default');
                }
                
                if (!Schema::hasColumn('typing_test_challenges', 'description')) {
                    $table->text('description')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('typing_test_challenges')) {
            Schema::table('typing_test_challenges', function (Blueprint $table) {
                $columns = [];
                
                if (Schema::hasColumn('typing_test_challenges', 'target_wpm')) {
                    $columns[] = 'target_wpm';
                }
                
                if (Schema::hasColumn('typing_test_challenges', 'target_accuracy')) {
                    $columns[] = 'target_accuracy';
                }
                
                if (Schema::hasColumn('typing_test_challenges', 'points_reward')) {
                    $columns[] = 'points_reward';
                }
                
                if (Schema::hasColumn('typing_test_challenges', 'created_by')) {
                    $columns[] = 'created_by';
                }
                
                if (Schema::hasColumn('typing_test_challenges', 'word_list')) {
                    $columns[] = 'word_list';
                }
                
                if (Schema::hasColumn('typing_test_challenges', 'description')) {
                    $columns[] = 'description';
                }
                
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
