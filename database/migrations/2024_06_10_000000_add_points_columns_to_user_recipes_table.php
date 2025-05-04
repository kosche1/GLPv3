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
            $table->integer('potential_points')->default(0)->after('score');
            $table->boolean('points_awarded')->default(false)->after('potential_points');
            $table->timestamp('points_awarded_at')->nullable()->after('points_awarded');
            $table->foreignId('approved_by')->nullable()->after('points_awarded_at')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_recipes', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['potential_points', 'points_awarded', 'points_awarded_at', 'approved_by']);
        });
    }
};
