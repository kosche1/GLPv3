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
        if (!Schema::hasTable('forum_comments')) {
            Schema::create('forum_comments', function (Blueprint $table) {
                $table->id();
                $table->text('content');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('forum_topic_id')->constrained()->onDelete('cascade');
                $table->foreignId('parent_id')->nullable()->constrained('forum_comments')->onDelete('cascade');
                $table->integer('likes_count')->default(0);
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
        Schema::dropIfExists('forum_comments');
    }
};
