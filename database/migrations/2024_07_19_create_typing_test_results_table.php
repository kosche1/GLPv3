<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Skip this migration as the table was already created in an earlier migration
        // This prevents the "table already exists" error
        if (Schema::hasTable('typing_test_results')) {
            // Table already exists, check if we need to add any missing columns
            Schema::table('typing_test_results', function (Blueprint $table) {
                if (!Schema::hasColumn('typing_test_results', 'accuracy') &&
                    Schema::hasColumn('typing_test_results', 'wpm')) {
                    // Convert integer accuracy to decimal if needed
                    $table->decimal('accuracy', 5, 2)->change();
                }

                if (!Schema::hasColumn('typing_test_results', 'word_count')) {
                    $table->integer('word_count')->nullable()->after('accuracy');
                }
            });
            return;
        }

        // Only create if it doesn't exist (this is a fallback, the check above should prevent this from running)
        Schema::create('typing_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('wpm');
            $table->integer('cpm');
            $table->decimal('accuracy', 5, 2);
            $table->integer('word_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Don't drop the table in down() since it might be used by other migrations
        // Only drop columns that were specifically added by this migration
        if (Schema::hasTable('typing_test_results') &&
            Schema::hasColumn('typing_test_results', 'word_count')) {
            Schema::table('typing_test_results', function (Blueprint $table) {
                $table->dropColumn('word_count');
            });
        }
    }
};
