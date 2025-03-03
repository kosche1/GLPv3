<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralProgram extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "description",
        "referrer_points",
        "referee_points",
        "is_active",
        "additional_rewards",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "boolean",
        "additional_rewards" => "array",
    ];

    /**
     * Get the referrals using this program.
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }
}
