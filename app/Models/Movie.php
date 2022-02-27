<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'release_date',
        'poster'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'release_date' => 'datetime:Y-m-d',
    ];

    /**
     * Get the users that have added this movie to their collection.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Collectible::class);
    }

    /**
     * Formats the release date for the frontend. Y-m-d or TBA basically.
     *
     * @return string
     */
    public function getReleaseDateFormatted(): string
    {
        return ! is_null($this->release_date) ? $this->release_date->toFormattedDateString() : 'N/A';
    }
}
