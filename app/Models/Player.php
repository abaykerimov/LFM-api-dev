<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'title', 'position', 'skill', 'age', 'team_id'
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }
}
