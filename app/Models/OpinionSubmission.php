<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpinionSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'author_email',
        'author_phone',
        'author_designation',
        'author_bio',
        'author_photo',
        'title',
        'topic',
        'content',
        'featured_image',
        'status',
        'admin_notes',
        'approved_post_id',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Relationship with the published Post if approved.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'approved_post_id');
    }

    /**
     * Scope for pending reviews.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved submissions.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected submissions.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get author photo URL with fallback.
     */
    public function getAuthorPhotoUrlAttribute()
    {
        if ($this->author_photo && file_exists(public_path($this->author_photo))) {
            return asset($this->author_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->author_name) . '&background=fecaca&color=b91c1c&size=200';
    }

    /**
     * Get featured image URL with fallback.
     */
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image && file_exists(public_path($this->featured_image))) {
            return asset($this->featured_image);
        }
        return null;
    }
}
