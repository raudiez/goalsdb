<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model{

	public static function getByID($id){
		return DB::table('competitions')->where('id', $id)->first();
	}

}
