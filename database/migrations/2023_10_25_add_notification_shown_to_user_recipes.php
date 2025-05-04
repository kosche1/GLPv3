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
        Schema::table('user_recipes', function (Blueprint $table) {
            $table->boolean('notification_shown')->default(false)->after('points_awarded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_recipes', function (Blueprint $table) {
            $table->dropColumn('notification_shown');
        });
    }
};
