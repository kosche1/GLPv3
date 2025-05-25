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
        Schema::table('typing_test_results', function (Blueprint $table) {
            if (!Schema::hasColumn('typing_test_results', 'challenge_id')) {
                $table->foreignId('challenge_id')->nullable()->after('user_id')->constrained('typing_test_challenges')->onDelete('set null');
            }

            // Add approval-related columns
            if (!Schema::hasColumn('typing_test_results', 'approved')) {
                $table->boolean('approved')->default(false)->after('errors');
            }

            if (!Schema::hasColumn('typing_test_results', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('approved')->constrained('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('typing_test_results', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }

            if (!Schema::hasColumn('typing_test_results', 'points_awarded')) {
                $table->boolean('points_awarded')->default(false)->after('approved_at');
            }

            if (!Schema::hasColumn('typing_test_results', 'notification_shown')) {
                $table->boolean('notification_shown')->default(false)->after('points_awarded');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('typing_test_results', function (Blueprint $table) {
            // Drop approval-related columns
            $columnsToCheck = [
                'notification_shown',
                'points_awarded',
                'approved_at',
                'approved_by',
                'approved',
                'challenge_id'
            ];

            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('typing_test_results', $column)) {
                    if (in_array($column, ['challenge_id', 'approved_by'])) {
                        $table->dropForeign([$column]);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};
