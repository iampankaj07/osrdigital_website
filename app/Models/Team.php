<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes; // Enables soft deletes

    protected $fillable = [
        'name', 
        'designation', 
        'image', 
        'linkedIn', 
        'github',
        'email'
    ];

    protected $dates = ['deleted_at']; // Optional in Laravel 10+, but safe to keep
}
