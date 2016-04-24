<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;

use Illuminate\Http\Request;

use App\Http\Requests;

class TeamsController extends Controller{
    public function index(){
    	$teams = Team::all();
    	return view('teams/list', compact('teams'));
    }

    public function show($id,$order_by='goals_club',$order_by_dir='desc'){
    	$teams = Team::all();
    	$team = Team::getByID($id);
    	$players = Player::getByTeamID_orderBy($id,$order_by,$order_by_dir);

    	return view('teams/show', compact('teams','team','players'));
    }

    public function save($id){
        //do something
        return redirect('/teams/show/'.$id);
    }
}