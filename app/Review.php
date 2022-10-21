<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{   
    protected $fillable=[
        'author',
        'content',
        'vote',
        'user_id',
        'created_at'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
