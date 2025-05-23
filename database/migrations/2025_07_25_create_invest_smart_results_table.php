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
        if (!Schema::hasTable('invest_smart_results')) {
            Schema::create('invest_smart_results', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('portfolio_id')->constrained('invest_smart_portfolios')->onDelete('cascade');
                $table->decimal('total_value', 15, 2)->comment('Total portfolio value including cash');
                $table->decimal('cash_balance', 15, 2)->comment('Cash balance at time of result');
                $table->decimal('portfolio_value', 15, 2)->comment('Value of stocks only');
                $table->decimal('total_return', 15, 2)->comment('Absolute return in currency');
                $table->decimal('total_return_percent', 8, 2)->comment('Percentage return');
                $table->integer('stock_count')->comment('Number of different stocks');
                $table->integer('transaction_count')->comment('Number of transactions made');
                $table->json('snapshot_data')->nullable()->comment('Snapshot of portfolio at time of result');
                $table->text('notes')->nullable()->comment('User notes about their strategy');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_smart_results');
    }
};
