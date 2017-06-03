<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCSeason extends Model{

	protected $table = 'lofc_seasons';

	public static function getByID($id){
		return DB::table('lofc_seasons')->where('id', $id)->first();
	}

}
