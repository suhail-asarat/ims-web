<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'website',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Relationship with manuscripts
    public function manuscripts(): HasMany
    {
        return $this->hasMany(Manuscript::class);
    }

    // Get manuscripts by status
    public function pendingManuscripts()
    {
        return $this->manuscripts()->where('status', 'pending');
    }

    public function publishedManuscripts()
    {
        return $this->manuscripts()->where('status', 'published');
    }

    // Count manuscripts by status
    public function getTotalManuscriptsAttribute()
    {
        return $this->manuscripts()->count();
    }

    public function getPublishedBooksCountAttribute()
    {
        return $this->manuscripts()->where('status', 'published')->count();
    }
}
