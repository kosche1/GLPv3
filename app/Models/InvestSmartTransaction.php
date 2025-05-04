<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestSmartTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_id',
        'type',
        'symbol',
        'name',
        'quantity',
        'price',
        'total',
        'transaction_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    /**
     * Get the portfolio that owns the transaction.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(InvestSmartPortfolio::class, 'portfolio_id');
    }
}
