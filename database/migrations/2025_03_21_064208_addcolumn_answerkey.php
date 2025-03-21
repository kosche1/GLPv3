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
        //
        Schema::table('tasks', function (Blueprint $table) {
            $table->json('answer_key')->nullable()->after('completion_criteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('answer_key');
        });
    }
};
