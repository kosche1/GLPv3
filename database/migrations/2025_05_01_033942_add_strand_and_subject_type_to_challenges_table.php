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
        Schema::table('challenges', function (Blueprint $table) {
            // Add foreign key for strand
            $table->foreignId('strand_id')->nullable()->after('tech_category')->constrained()->nullOnDelete();

            // Add foreign key for subject type
            $table->foreignId('subject_type_id')->nullable()->after('strand_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropForeign(['strand_id']);
            $table->dropForeign(['subject_type_id']);
            $table->dropColumn(['strand_id', 'subject_type_id']);
        });
    }
};
