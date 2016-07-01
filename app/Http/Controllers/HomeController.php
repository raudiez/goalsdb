<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Player;
use App\Team;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $teams = Team::all()->sortBy('name');
        $players = Player::joinPlayersGoals_Club();
        $total_goals = Player::getAllPlayersGoals();
        return view('home',compact('teams','players','total_goals'));
    }
}
