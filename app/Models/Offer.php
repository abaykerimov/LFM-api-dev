<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'auction_id',
        'user_id',
        'cost',
        'team_id',

    ];

    protected $dates = ['created_at', 'updated_at'];
	protected $touches = ['auction'];

    public function auction() {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

	public function team() {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
