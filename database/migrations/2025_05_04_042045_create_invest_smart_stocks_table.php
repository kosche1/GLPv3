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
        if (!Schema::hasTable('invest_smart_stocks')) {
            Schema::create('invest_smart_stocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_id')->constrained('invest_smart_portfolios')->onDelete('cascade');
                $table->string('symbol', 10);
                $table->string('name');
                $table->integer('quantity');
                $table->decimal('average_price', 15, 2);
                $table->decimal('total_cost', 15, 2);
                $table->decimal('current_price', 15, 2);
                $table->timestamps();

                // Unique constraint to prevent duplicate stocks in a portfolio
                $table->unique(['portfolio_id', 'symbol']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_smart_stocks');
    }
};
