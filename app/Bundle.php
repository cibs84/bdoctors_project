<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'name', 
        'duration',
        'price',
        'code'
    ];

    public function users() {
        return $this->belongsToMany('App\User', 'user_bundle');
    }
}
