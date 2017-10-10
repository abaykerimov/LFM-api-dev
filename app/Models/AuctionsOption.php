<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class AuctionsOption extends Model
{
    protected $fillable = [
        'started_at',
        'user_id',
        'turnir_year'
    ];

    protected $dates = ['created_at', 'started_at', 'updated_at'];

    public function creator() {
        return $this->belongsTo(User::class);
    }

    public function auctions() {
        return $this->hasMany(Auction::class);
    }
}
