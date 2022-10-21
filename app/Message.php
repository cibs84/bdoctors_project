<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=[
        'author',
        'email',
        'content',
        'user_id',
        'created_at'
    ];
    public function user() {
        return $this->belongsTo('App\User');
    }
}
