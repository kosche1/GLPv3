<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestSmartResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'portfolio_id',
        'total_value',
        'cash_balance',
        'portfolio_value',
        'total_return',
        'total_return_percent',
        'stock_count',
        'transaction_count',
        'snapshot_data',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_value' => 'decimal:2',
        'cash_balance' => 'decimal:2',
        'portfolio_value' => 'decimal:2',
        'total_return' => 'decimal:2',
        'total_return_percent' => 'decimal:2',
        'snapshot_data' => 'json',
    ];

    /**
     * Get the user that owns the result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the portfolio associated with this result.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(InvestSmartPortfolio::class, 'portfolio_id');
    }
}
