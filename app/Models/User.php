<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens; // Import the HasApiTokens trait

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens; // Use the HasApiTokens trait provided by Sanctum
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio', // Additional field: short bio or description about the user
        'location', // Additional field: user's location
        'preferences', // Additional field: user's preferences stored as JSON
        'social_media_links', // Additional field: social media links stored as JSON
        'contact', // Additional field: additional contact information
        'permissions', // Additional field: roles and permissions system
        'email_verified', // Additional field: track email verification status
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'preferences' => 'array', // Casting preferences field to array
        'social_media_links' => 'array', // Casting social media links field to array
        'email_verified' => 'boolean', // Casting email_verified field to boolean
    ];

    /**
     * Get the user's notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the notes collaborated by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collaboratedNotes()
    {
        return $this->belongsToMany(Note::class)->withTimestamps();
    }
}