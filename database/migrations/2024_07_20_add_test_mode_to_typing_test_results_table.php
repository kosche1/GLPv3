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
        if (Schema::hasTable('typing_test_results')) {
            Schema::table('typing_test_results', function (Blueprint $table) {
                if (!Schema::hasColumn('typing_test_results', 'test_mode')) {
                    $table->string('test_mode')->default('words')->after('word_count');
                }

                if (!Schema::hasColumn('typing_test_results', 'time_limit')) {
                    $table->integer('time_limit')->nullable()->after('test_mode');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('typing_test_results')) {
            Schema::table('typing_test_results', function (Blueprint $table) {
                $columns = [];

                if (Schema::hasColumn('typing_test_results', 'test_mode')) {
                    $columns[] = 'test_mode';
                }

                if (Schema::hasColumn('typing_test_results', 'time_limit')) {
                    $columns[] = 'time_limit';
                }

                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
