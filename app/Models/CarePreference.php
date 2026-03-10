<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarePreference extends Model
{
    protected $fillable = [
        'user_id',
        'likes',
        'dislikes',
        'care_preferences',
        'info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
