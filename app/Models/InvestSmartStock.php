<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestSmartStock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_id',
        'symbol',
        'name',
        'quantity',
        'average_price',
        'total_cost',
        'current_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'average_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'current_price' => 'decimal:2',
    ];

    /**
     * Get the portfolio that owns the stock.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(InvestSmartPortfolio::class, 'portfolio_id');
    }

    /**
     * Get the market data for this stock.
     */
    public function marketData(): BelongsTo
    {
        return $this->belongsTo(InvestSmartMarketData::class, 'symbol', 'symbol');
    }
}
