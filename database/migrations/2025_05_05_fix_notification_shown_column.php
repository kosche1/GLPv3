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
        if (Schema::hasTable('user_recipes')) {
            if (!Schema::hasColumn('user_recipes', 'notification_shown')) {
                Schema::table('user_recipes', function (Blueprint $table) {
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
        if (Schema::hasTable('user_recipes') && Schema::hasColumn('user_recipes', 'notification_shown')) {
            Schema::table('user_recipes', function (Blueprint $table) {
                $table->dropColumn('notification_shown');
            });
        }
    }
};
