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

    public function show($id){
    	$teams = Team::all();
    	$team = Team::getByID($id);
    	$players = Player::getByTeamID_orderBy($id,'goals_club');

    	return view('teams/show', compact('teams','team','players'));
    }
}