<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Player;
use App\Team;
use App\User;

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
        $owners = User::all()->sortBy('name');
        $teams = Team::all()->sortBy('name');
        $players = Player::joinPlayersGoals_Club();
        $total_goals = Player::getAllPlayersGoals();
        //$goals_by_owner = Player::joinOwnerTotalGoals();
        $goals_by_club = Player::joinClubTotalGoals();

        return view('home',compact('owners', 'teams','players','total_goals',/*'goals_by_owner', */'goals_by_club'));
    }
}
