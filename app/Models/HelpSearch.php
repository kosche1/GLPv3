<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'query',
        'results_count',
        'found_helpful',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'found_helpful' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function logSearch(string $query, int $resultsCount, ?int $userId = null): self
    {
        return static::create([
            'user_id' => $userId,
            'query' => $query,
            'results_count' => $resultsCount,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public static function getPopularSearches(int $limit = 10): array
    {
        return static::selectRaw('query, COUNT(*) as search_count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->limit($limit)
            ->pluck('query')
            ->toArray();
    }
}
