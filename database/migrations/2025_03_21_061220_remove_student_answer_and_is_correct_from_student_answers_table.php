<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            $table->dropColumn(['student_answer', 'is_correct']);
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