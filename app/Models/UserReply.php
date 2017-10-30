<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReply extends Model
{
    protected $fillable = [
        'problem',
        'wish',
        'user_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $table = 'user_replies';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
