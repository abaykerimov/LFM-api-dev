<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'photo_200', 'first_name', 'last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];*/

    public function getAuctionOptions() {
        return $this->hasMany(AuctionsOption::class);
    }

    public function auctions() {
        return $this->hasMany(Auction::class);
    }

    public function offers() {
        return $this->hasMany(Offer::class);
    }
}
