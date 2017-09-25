<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCReglamento extends Model{

	protected $table = 'lofc_goals';

	public static function getText(){
		return DB::table('lofc_reglamento')->first();
	}

	public static function updateText($reglamento){
		DB::table('lofc_reglamento')->where('id', 1)->
			update([
				'reglamento' => $reglamento,
				]);
	}

}
