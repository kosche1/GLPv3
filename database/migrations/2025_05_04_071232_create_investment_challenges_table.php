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
        // Skip if the table already exists
        if (!Schema::hasTable('investment_challenges')) {
            Schema::create('investment_challenges', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->enum('difficulty', ['beginner', 'intermediate', 'advanced']);
                $table->integer('duration')->comment('Duration in days');
                $table->integer('points')->default(100);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            // If the table exists, check if we need to update the schema
            Schema::table('investment_challenges', function (Blueprint $table) {
                // Add any missing columns or modify existing ones if needed
                if (!Schema::hasColumn('investment_challenges', 'duration')) {
                    $table->integer('duration')->comment('Duration in days')->nullable();
                }

                // If difficulty is not an enum, we might need to modify it
                // This is a complex operation and might require a separate migration
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_challenges');
    }
};
