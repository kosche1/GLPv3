<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('student_answers', 'student_answer')) {
                $columnsToDrop[] = 'student_answer';
            }
            if (Schema::hasColumn('student_answers', 'is_correct')) {
                $columnsToDrop[] = 'is_correct';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            $table->text('student_answer')->nullable();
            $table->boolean('is_correct')->nullable();
        });
    }
};