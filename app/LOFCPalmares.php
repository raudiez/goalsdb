<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCPalmares extends Model{

	protected $table = 'lofc_goals';

	public static function getText(){
		return DB::table('lofc_palmares')->first();
	}

	public static function updateText($palmares){
		DB::table('lofc_palmares')->where('id', 1)->
			update([
				'palmares' => $palmares,
				]);
	}

}
