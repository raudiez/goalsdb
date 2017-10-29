<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCTeam extends Model{

	protected $table = 'lofc_teams';

	public $timestamps = false;

	public static function getByID($id){
		return DB::table('lofc_teams')->where('id', $id)->first();
	}

	public static function getBySeasonID($id_season){
		return DB::table('lofc_teams')->where('id_season', $id_season)->orderBy('name','asc')->get();
	}

	public static function getAllLogos(){
		return DB::table('lofc_teams')->distinct()->select('logo_img')->where('logo_img', '!=', '')->get();
	}

	public static function updateTeam($id, $name, $logo_img){
		DB::table('lofc_teams')->where('id', $id)->
			update([
				'name' => $name,
				'logo_img' => $logo_img,
				]);
	}

}
