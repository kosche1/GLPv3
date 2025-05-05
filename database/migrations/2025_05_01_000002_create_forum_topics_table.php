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
        if (!Schema::hasTable('forum_topics')) {
            Schema::create('forum_topics', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('content');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('forum_category_id')->constrained()->onDelete('cascade');
                $table->integer('views_count')->default(0);
                $table->integer('likes_count')->default(0);
                $table->integer('comments_count')->default(0);
                $table->boolean('is_pinned')->default(false);
                $table->boolean('is_locked')->default(false);
                $table->timestamp('last_activity_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_topics');
    }
};
