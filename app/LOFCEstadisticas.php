<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCEstadisticas extends Model{

	protected $table = 'lofc_goals';

	public static function getText(){
		return DB::table('lofc_stats')->first();
	}

	public static function updateText($stats){
		DB::table('lofc_stats')->where('id', 1)->
			update([
				'stats' => $stats,
				]);
	}

}
