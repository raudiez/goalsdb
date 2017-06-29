<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCGoals extends Model{

	protected $table = 'lofc_goals';

	public static function getByID($id){
		return DB::table('lofc_goals')->where('id', $id)->first();
	}

	public static function insertOrUpdate($id_player, $id_competition, $count){
		DB::insert('INSERT INTO lofc_goals (id_player, id_competition, count) VALUES (:id_player, :id_competition, :count1) ON DUPLICATE KEY UPDATE count = count + :count2', ['id_player' => $id_player, 'id_competition' => $id_competition, 'count1' =>  $count, 'count2' => $count]);
	}

}
