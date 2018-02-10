<?php

namespace App\Models;

use App\Tournament;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'player_id', 'avatar', 'title', 'position', 'skill', 'date_of_birth', 'dob', 'age', 'team_id'
    ];

    public $timestamps = false;

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }
}
