<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\Record;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller{
    public function index(){
        $owners = User::all()->sortBy('name');
    	$teams = Team::all()->sortBy('name');
    	return view('owners/list', compact('owners', 'teams'));
    }

    public function show($id){
        $owners = User::all()->sortBy('name');
    	$teams = Team::all()->sortBy('name');
    	$owner = User::getByID($id);

    	return view('owners/show', compact('owners', 'teams','team'));
    }

}