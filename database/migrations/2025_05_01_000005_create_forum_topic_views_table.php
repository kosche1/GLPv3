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
        if (!Schema::hasTable('forum_topic_views')) {
            Schema::create('forum_topic_views', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('forum_topic_id')->constrained()->onDelete('cascade');
                $table->timestamp('viewed_at');

                // Ensure a user can only have one view record per topic
                $table->unique(['user_id', 'forum_topic_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_topic_views');
    }
};
