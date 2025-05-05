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
        // Check if the table exists before trying to modify it
        if (Schema::hasTable('user_recipes')) {
            Schema::table('user_recipes', function (Blueprint $table) {
                // Check if columns don't already exist
                if (!Schema::hasColumn('user_recipes', 'potential_points')) {
                    $table->integer('potential_points')->default(0)->after('score');
                }

                if (!Schema::hasColumn('user_recipes', 'points_awarded')) {
                    $table->boolean('points_awarded')->default(false)->after('potential_points');
                }

                if (!Schema::hasColumn('user_recipes', 'points_awarded_at')) {
                    $table->timestamp('points_awarded_at')->nullable()->after('points_awarded');
                }

                if (!Schema::hasColumn('user_recipes', 'approved_by')) {
                    $table->foreignId('approved_by')->nullable()->after('points_awarded_at')->constrained('users')->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the table exists before trying to modify it
        if (Schema::hasTable('user_recipes')) {
            Schema::table('user_recipes', function (Blueprint $table) {
                if (Schema::hasColumn('user_recipes', 'approved_by')) {
                    $table->dropForeign(['approved_by']);
                }

                $columns = [];
                if (Schema::hasColumn('user_recipes', 'potential_points')) {
                    $columns[] = 'potential_points';
                }
                if (Schema::hasColumn('user_recipes', 'points_awarded')) {
                    $columns[] = 'points_awarded';
                }
                if (Schema::hasColumn('user_recipes', 'points_awarded_at')) {
                    $columns[] = 'points_awarded_at';
                }
                if (Schema::hasColumn('user_recipes', 'approved_by')) {
                    $columns[] = 'approved_by';
                }

                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
