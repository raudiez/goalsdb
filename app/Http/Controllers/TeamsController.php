<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\Record;

use Illuminate\Http\Request;

use App\Http\Requests;

class TeamsController extends Controller{
    public function index(){
    	$teams = Team::all()->sortBy('name');
    	return view('teams/list', compact('teams'));
    }

    public function show($id,$order_by='goals_club',$order_by_dir='desc'){
    	$teams = Team::all()->sortBy('name');
        $records = Record::joinRecords_byTeamID($id);
    	$team = Team::getByID($id);
    	$players = Player::getByTeamID_orderBy($id,$order_by,$order_by_dir);

    	return view('teams/show', compact('teams','team','players','records'));
    }

    public function save(Request $request, $id){
        $teams = Team::all()->sortBy('name');

        $new_goals = $request->input('new_goals');
        $old_goals = unserialize($request->input('old_goals'));
        for ($i=0; $i < count($old_goals); $i++) {
            if($old_goals[$i]['id'] == $new_goals[$i]['id']){
                if($old_goals[$i]['goals_club'] != $new_goals[$i]['goals_club'] or $old_goals[$i]['goals_career'] != $new_goals[$i]['goals_career']){
                    Player::updateByID($new_goals[$i]['id'],$new_goals[$i]['name'],$new_goals[$i]['goals_club'],$new_goals[$i]['goals_career']);
                }
            }
        }

        return redirect('teams/show/'.$id);
    }
}