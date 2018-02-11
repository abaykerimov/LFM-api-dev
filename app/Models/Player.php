<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'player_id', 'avatar', 'title', 'position', 'skill', 'date_of_birth', 'dob', 'age', 'team_id', 'tournament_id'
    ];

    public $timestamps = false;

    public function team() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }
}
