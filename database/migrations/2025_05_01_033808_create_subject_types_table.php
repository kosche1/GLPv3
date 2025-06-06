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
        Schema::create('subject_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // 'core', 'applied', 'specialized'
            $table->text('description')->nullable();
            $table->string('color')->nullable(); // For UI styling
            $table->string('icon')->nullable(); // For UI styling
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // For sorting
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_types');
    }
};
