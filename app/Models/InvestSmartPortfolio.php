<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestSmartPortfolio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'balance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:2',
    ];

    /**
     * Get the user that owns the portfolio.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the stocks for the portfolio.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(InvestSmartStock::class, 'portfolio_id');
    }

    /**
     * Get the transactions for the portfolio.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(InvestSmartTransaction::class, 'portfolio_id');
    }
}
