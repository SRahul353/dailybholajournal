<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'session_id',
        'device',
        'browser',
        'os',
        'url',
        'page_title',
        'post_id',
        'referer',
        'referer_source',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship with Post if the visitor read a specific article.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
