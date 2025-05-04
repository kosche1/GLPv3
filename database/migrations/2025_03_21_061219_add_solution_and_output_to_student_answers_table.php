<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('student_answers', 'solution')) {
                $table->text('solution')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'output')) {
                $table->text('output')->nullable();
            }
            if (!Schema::hasColumn('student_answers', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            $table->dropColumn(['solution', 'output', 'status']);
        });
    }
};