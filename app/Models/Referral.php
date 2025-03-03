<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "referrer_id",
        "referee_id",
        "referral_program_id",
        "referral_code",
        "status",
        "completed_at",
        "referrer_rewarded",
        "referee_rewarded",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "completed_at" => "datetime",
        "referrer_rewarded" => "boolean",
        "referee_rewarded" => "boolean",
    ];

    /**
     * Get the user who referred (existing user).
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, "referrer_id");
    }

    /**
     * Get the user who was referred (new user).
     */
    public function referee()
    {
        return $this->belongsTo(User::class, "referee_id");
    }

    /**
     * Get the referral program.
     */
    public function program()
    {
        return $this->belongsTo(ReferralProgram::class, "referral_program_id");
    }
}
