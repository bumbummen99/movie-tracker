<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the collection of movies for this user.
     */
    public function collection(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, Collectible::class);
    }

    /**
     * Get the collectibles for this user.
     */
    public function collectibles(): HasMany
    {
        return $this->hasMany(Collectible::class);
    }

    /**
     * Helper function to retrieve the current user with correct type hint.
     *
     * @return self|null
     */
    public static function current(): ?self
    {
        return Auth::user();
    }
}
