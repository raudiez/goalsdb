<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function players(){
        return $this->hasMany(Player::class);
    }

    public static function getByID($id){
        return DB::table('users')->where('id', $id)->first();
    }
}
