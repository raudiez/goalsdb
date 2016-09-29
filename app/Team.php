<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Team extends Model{

	//protected $fillable = ['name'];

	public static function getByID($id){
		return DB::table('teams')->where('id', $id)->first();
	}

	public static function getByOwnerID($owner_id){
		return DB::table('teams')->
			where('owner_id', $owner_id)->
			orderBy('name','asc')->
			get();
	}
}
