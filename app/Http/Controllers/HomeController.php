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
        $players16 = Player::joinPlayersGoals_Club(16);
        $players17 = Player::joinPlayersGoals_Club(17);
        $total_goals = Player::getAllPlayersGoals();
        $goals_by_owner = Player::joinOwnerTotalGoals();
        $goals_by_club_16 = Player::joinClubTotalGoals(16);
        $goals_by_club_17 = Player::joinClubTotalGoals(17);

        return view('home',compact('owners', 'teams', 'players16', 'players17', 'total_goals', 'goals_by_owner', 'goals_by_club_16', 'goals_by_club_17'));
    }
}
