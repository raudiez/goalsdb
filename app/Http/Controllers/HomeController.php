<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Player;
use App\Team;
use App\User;
use App\LOFCSeason;

class HomeController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $owners = User::all()->sortBy('name');
        $teams = Team::all()->sortBy('name');
        $lofc_seasons = LOFCSeason::all();
        $players16 = Player::joinPlayersGoals_Club(16);
        $players17 = Player::joinPlayersGoals_Club(17);
        $total_goals = Player::getAllPlayersGoals();
        $goals_by_owner = Player::joinOwnerTotalGoals();
        $goals_by_club_16 = Player::joinClubTotalGoals(16);
        $goals_by_club_17 = Player::joinClubTotalGoals(17);

        return view('home',compact('owners', 'teams', 'lofc_seasons', 'players16', 'players17', 'total_goals', 'goals_by_owner', 'goals_by_club_16', 'goals_by_club_17'));
    }
}
