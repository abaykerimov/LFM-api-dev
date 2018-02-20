<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'title', 'is_taken'
    ];

    public function players() {
        return $this->hasMany(Player::class);
    }

    public function user() {
        return $this->belongsToMany(User::class, 'user_team')->withPivot('tournament_id', 'is_main');
    }
}
