<?php

namespace App;

use App\Models\AuctionsOption;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'created_at'
    ];

//    protected $dates = ['created_at'];

    public function auction_options() {
        return $this->hasMany(AuctionsOption::class);
    }
}
