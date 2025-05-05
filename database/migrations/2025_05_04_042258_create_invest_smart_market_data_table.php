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
        if (!Schema::hasTable('invest_smart_market_data')) {
            Schema::create('invest_smart_market_data', function (Blueprint $table) {
                $table->id();
                $table->string('symbol', 10)->unique();
                $table->string('name');
                $table->decimal('price', 15, 2);
                $table->decimal('change', 15, 2);
                $table->decimal('change_percent', 8, 2);
                $table->bigInteger('volume');
                $table->string('industry');
                $table->decimal('market_cap', 20, 2);
                $table->decimal('pe', 10, 2)->nullable();
                $table->decimal('high_52_week', 15, 2);
                $table->decimal('low_52_week', 15, 2);
                $table->decimal('dividend_yield', 8, 2)->nullable();
                $table->text('description')->nullable();
                $table->json('historical_data')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_smart_market_data');
    }
};
