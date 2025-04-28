<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('typing_test_results', function (Blueprint $table) {
            $table->string('test_mode')->default('words')->after('word_count');
            $table->integer('time_limit')->nullable()->after('test_mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('typing_test_results', function (Blueprint $table) {
            $table->dropColumn(['test_mode', 'time_limit']);
        });
    }
};
