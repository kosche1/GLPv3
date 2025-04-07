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
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'due_date')) {
                $table->date('due_date')->nullable()->after('is_active')
                    ->comment('Due date for task completion');
            }
            
            if (!Schema::hasColumn('tasks', 'title')) {
                $table->string('title')->nullable()->after('name')
                    ->comment('Alternative title for the task');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'due_date')) {
                $table->dropColumn('due_date');
            }
            
            if (Schema::hasColumn('tasks', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};
