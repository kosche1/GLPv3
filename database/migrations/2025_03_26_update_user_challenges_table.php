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
        Schema::table('user_challenges', function (Blueprint $table) {
            if (!Schema::hasColumn('user_challenges', 'progress')) {
                $table->float('progress')->default(0);
            }
            
            if (!Schema::hasColumn('user_challenges', 'status')) {
                $table->string('status')->default('not_started');
            }
            
            if (!Schema::hasColumn('user_challenges', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_challenges', function (Blueprint $table) {
            $table->dropColumn(['progress', 'status', 'completed_at']);
        });
    }
}; 