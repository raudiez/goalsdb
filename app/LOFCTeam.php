<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCTeam extends Model{

	protected $table = 'lofc_teams';

	public static function getByID($id){
		return DB::table('lofc_teams')->where('id', $id)->first();
	}

}
