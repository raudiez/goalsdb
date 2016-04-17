<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Team extends Model{

	//protected $fillable = ['name'];

	public function players(){
		return $this->hasMany(Player::class);
	}

	public static function getByID($id){
		return DB::table('teams')->where('id', $id)->first();
	}
}
