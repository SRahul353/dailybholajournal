<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'ip_address',
        'user_agent',
        'vote',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
