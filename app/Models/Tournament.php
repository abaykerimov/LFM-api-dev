<?php

namespace App;

use App\Models\AuctionsOption;
use App\Models\Player;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'created_at', 'ended_at',
    ];

//    protected $dates = ['created_at'];

    public function auction_options() {
        return $this->hasMany(AuctionsOption::class);
    }

    public function players() {
        return $this->hasMany(Player::class);
    }

}
