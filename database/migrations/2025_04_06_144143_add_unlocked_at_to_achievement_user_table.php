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
        Schema::table('achievement_user', function (Blueprint $table) {
            if (!Schema::hasColumn('achievement_user', 'unlocked_at')) {
                $table->timestamp('unlocked_at')->nullable()->after('achievement_id');
            }

            if (!Schema::hasColumn('achievement_user', 'progress')) {
                $table->integer('progress')->nullable()->after('unlocked_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_user', function (Blueprint $table) {
            if (Schema::hasColumn('achievement_user', 'unlocked_at')) {
                $table->dropColumn('unlocked_at');
            }

            if (Schema::hasColumn('achievement_user', 'progress')) {
                $table->dropColumn('progress');
            }
        });
    }
};
