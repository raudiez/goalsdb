<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Player;
use App\Team;
use Mail;

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
    public function index(){
        $players16 = Player::joinPlayersGoals_Club(16);
        $players17 = Player::joinPlayersGoals_Club(17);
        $total_goals = Player::getAllPlayersGoals();
        $goals_by_owner = Player::joinOwnerTotalGoals();
        $goals_by_club_16 = Player::joinClubTotalGoals(16);
        $goals_by_club_17 = Player::joinClubTotalGoals(17);

        return view('home', compact('players16', 'players17', 'total_goals', 'goals_by_owner', 'goals_by_club_16', 'goals_by_club_17'));
    }

    public function disclaimer(){

        return view('disclaimer');
    }

    public function contact_form(){

        return view('contact_form');
    }

    public function contact_send(Request $request){

        $this->validate($request, [
            'subject' => 'required',
            'message_text' => 'required',
        ]);
        $subject = $request->input('subject');
        $message_text = $request->input('message_text');

        Mail::send('emails.contact', ['message_text' => $message_text, 'subject' => $subject], function ($m) use ($message_text, $subject) {
            $m->to('info.lofc@gmail.com')->subject('Contacto LOFC: '.$subject);
        });

        return redirect('');
    }
}
