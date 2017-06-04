<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\Record;
use App\User;
use App\LOFCSeason;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $owners = User::all()->sortBy('name');
    	$teams = Team::all()->sortBy('name');
    	return view('owners/list', compact('owners', 'teams'));
    }

    public function show($id){
        $owners = User::all()->sortBy('name');
    	$teams = Team::all()->sortBy('name');
    	$owner = User::getByID($id);
        $clubs = Team::getByOwnerID($id);

    	return view('owners/show', compact('owners', 'owner', 'teams', 'clubs'));
    }

}