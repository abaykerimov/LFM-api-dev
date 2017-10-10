<?php
/**
 * Created by IntelliJ IDEA.
 * User: Rodion
 * Date: 05.10.2017
 * Time: 13:52
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserAuction extends Model
{
    protected $fillable = [
        'user_id',
        'auction_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function auction() {
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}