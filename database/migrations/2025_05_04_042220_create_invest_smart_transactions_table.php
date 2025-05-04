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
        Schema::create('invest_smart_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('invest_smart_portfolios')->onDelete('cascade');
            $table->enum('type', ['buy', 'sell']);
            $table->string('symbol', 10);
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamp('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_smart_transactions');
    }
};
