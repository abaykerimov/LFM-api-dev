<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'title'
    ];

    public function players() {
        return $this->hasMany(Player::class);
    }
}
