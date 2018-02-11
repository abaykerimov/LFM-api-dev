<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class AuctionsOption extends Model
{
    protected $fillable = [
        'started_at',
        'user_id',
        'turnir_year',
        'tournament_id'
    ];

    protected $dates = ['created_at', 'started_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function auctions() {
        return $this->hasMany(Auction::class);
    }
    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }
}
