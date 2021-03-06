<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\Record;

use Illuminate\Http\Request;

use App\Http\Requests;

class TeamsController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	return view('teams/list');
    }

    public function show($id,$order_by='goals_club',$order_by_dir='desc'){
        $team = Team::getByID($id);
        $records = Record::getRecordsByOwnerAndVersion($team->owner_id, $team->version);
    	$players = Player::getByOwnerAndVersion_orderBy($team->owner_id,$team->version,$order_by.'_'.$team->version,$order_by_dir);

    	return view('teams/show', compact('team', 'players', 'records'));
    }

    public function save(Request $request, $id){
        $version = $request->input('fifa_version');
        $new_goals = $request->input('new_goals');
        $old_goals = unserialize($request->input('old_goals'));
        for ($i=0; $i < count($old_goals); $i++) {
            if($old_goals[$i]['id'] == $new_goals[$i]['id']){
                if($old_goals[$i]['goals_club'] != $new_goals[$i]['goals_club'] or $old_goals[$i]['goals_career'] != $new_goals[$i]['goals_career']){
                    Player::updateByID($new_goals[$i]['id'],$new_goals[$i]['name'],$version,$new_goals[$i]['goals_club'],$new_goals[$i]['goals_career']);
                }
            }
        }

        return redirect('teams/show/'.$id);
    }
}