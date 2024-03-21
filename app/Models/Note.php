<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', // User who created the note
        'title', // Title of the note
        'content', // Content of the note
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['users']; // Eager load the users relationship by default

    /**
     * Get the users associated with the note.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Get the user who created the note.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}