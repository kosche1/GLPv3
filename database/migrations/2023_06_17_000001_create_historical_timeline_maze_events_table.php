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
        Schema::create('historical_timeline_maze_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historical_timeline_maze_id')->constrained()->onDelete('cascade');
            $table->string('era'); // ancient, medieval, renaissance, modern, contemporary
            $table->string('title');
            $table->string('year');
            $table->text('description');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_timeline_maze_events');
    }
};
