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
            // Check if the column doesn't already exist
            if (!Schema::hasColumn('user_recipes', 'notification_shown')) {
                Schema::table('user_recipes', function (Blueprint $table) {
                    // Don't specify 'after' since the points_awarded column might not exist yet
                    $table->boolean('notification_shown')->default(false);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the table exists before trying to modify it
        if (Schema::hasTable('user_recipes') && Schema::hasColumn('user_recipes', 'notification_shown')) {
            Schema::table('user_recipes', function (Blueprint $table) {
                $table->dropColumn('notification_shown');
            });
        }
    }
};
