<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Auction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'player_id',
        'initial_cost',
        'final_cost',
        'team_id',
        'auctions_option_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function player() {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function team() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function auctionOption() {
        return $this->belongsTo(AuctionsOption::class);
    }

    public function offers() {
        return $this->hasMany(Offer::class, 'auction_id');
    }
}
