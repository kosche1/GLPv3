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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('typing_test_results', function (Blueprint $table) {
            if (Schema::hasColumn('typing_test_results', 'challenge_id')) {
                $table->dropForeign(['challenge_id']);
                $table->dropColumn('challenge_id');
            }
        });
    }
};
