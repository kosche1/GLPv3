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
        if (!Schema::hasTable('student_answers')) {
            Schema::create('student_answers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('task_id')->constrained()->onDelete('cascade');
                $table->longText('submitted_text')->nullable();
                $table->string('submitted_file_path')->nullable();
                $table->string('submitted_url')->nullable();
                $table->json('submitted_data')->nullable();
                $table->json('student_answer')->nullable();
                $table->boolean('is_correct')->nullable();
                $table->decimal('score', 8, 2)->nullable();
                $table->text('feedback')->nullable();
                $table->text('solution')->nullable();
                $table->text('output')->nullable();
                $table->string('status')->default('submitted');
                $table->boolean('notification_shown')->default(false);
                $table->timestamp('evaluated_at')->nullable();
                $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
