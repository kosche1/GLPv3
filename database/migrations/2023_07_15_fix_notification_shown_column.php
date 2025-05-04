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
        if (Schema::hasTable('student_answers')) {
            if (!Schema::hasColumn('student_answers', 'notification_shown')) {
                Schema::table('student_answers', function (Blueprint $table) {
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
        if (Schema::hasTable('student_answers') && Schema::hasColumn('student_answers', 'notification_shown')) {
            Schema::table('student_answers', function (Blueprint $table) {
                $table->dropColumn('notification_shown');
            });
        }
    }
};
