<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all tasks with evaluation_type 'contains' to 'manual'
        DB::table('tasks')
            ->where('evaluation_type', 'contains')
            ->update(['evaluation_type' => 'manual']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a data migration, so we don't need to do anything in the down method
        // If needed, you could restore the original values, but that would require storing them somewhere
    }
};
