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
        Schema::create('backup_archives', function (Blueprint $table) {
            $table->id();
            $table->string('original_path')->comment('Original path of the backup file');
            $table->string('disk')->comment('Storage disk where backup was stored');
            $table->string('filename')->comment('Original filename of the backup');
            $table->string('size')->comment('Size of the backup file');
            $table->timestamp('backup_date')->comment('Date when backup was created');
            $table->timestamp('archived_date')->comment('Date when backup was archived/deleted');
            $table->foreignId('archived_by')->nullable()->constrained('users')->nullOnDelete()->comment('User who archived the backup');
            $table->text('notes')->nullable()->comment('Optional notes about the archive');
            $table->json('metadata')->nullable()->comment('Additional backup metadata');
            $table->timestamps();
            
            $table->index(['disk', 'archived_date']);
            $table->index('backup_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_archives');
    }
};
