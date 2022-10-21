<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'address',
        'slug',
        'phone_number',
        'service',
        'curriculum',
        'photo'
    ];

    protected $table = 'users';

    public function specializations() {
        return $this->belongsToMany('App\Specialization');
    }

    public function bundles() {
        return $this->belongsToMany('App\Bundle', 'user_bundle')->using('App\UserBundle')->withPivot(['expired_date'])->orderBy('created_date', 'desc');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }

    public function reviews() {
        return $this->hasMany('App\Review')->orderBy('created_at', 'desc');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
}
