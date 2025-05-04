<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestSmartMarketData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'symbol',
        'name',
        'price',
        'change',
        'change_percent',
        'volume',
        'industry',
        'market_cap',
        'pe',
        'high_52_week',
        'low_52_week',
        'dividend_yield',
        'description',
        'historical_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'change' => 'decimal:2',
        'change_percent' => 'decimal:2',
        'market_cap' => 'decimal:2',
        'pe' => 'decimal:2',
        'high_52_week' => 'decimal:2',
        'low_52_week' => 'decimal:2',
        'dividend_yield' => 'decimal:2',
        'historical_data' => 'array',
    ];

    /**
     * Get the portfolio stocks for this market data.
     */
    public function portfolioStocks(): HasMany
    {
        return $this->hasMany(InvestSmartStock::class, 'symbol', 'symbol');
    }
}
