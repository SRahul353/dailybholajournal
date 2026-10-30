<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'is_active',
        'yes_votes',
        'no_votes',
        'neutral_votes',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function getTotalVotesAttribute()
    {
        return $this->yes_votes + $this->no_votes + $this->neutral_votes;
    }

    public function getYesPercentAttribute()
    {
        $total = $this->total_votes;
        return $total > 0 ? round(($this->yes_votes / $total) * 100) : 0;
    }

    public function getNoPercentAttribute()
    {
        $total = $this->total_votes;
        return $total > 0 ? round(($this->no_votes / $total) * 100) : 0;
    }

    public function getNeutralPercentAttribute()
    {
        $total = $this->total_votes;
        return $total > 0 ? round(($this->neutral_votes / $total) * 100) : 0;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
