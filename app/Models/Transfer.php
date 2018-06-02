<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'title',
        'transfer_id',
        'player_id',
        'team_id',
        'cost',
        'transfer_type',
        'loan_cost',
        'loan_type',
        'user_id',
        'description',
        'auction_option_id',
        'status',
        'player_title',
    ];

    protected $dates = ['created_at', 'updated_at'];


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function player() {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function team() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function auctionOption() {
        return $this->belongsTo(AuctionsOption::class, 'auction_option_id');
    }

    public function children() {
        return $this->hasMany(Transfer::class, 'transfer_id');
    }
    public function parent() {
        return $this->belongsTo(Transfer::class, 'transfer_id');
    }

}
