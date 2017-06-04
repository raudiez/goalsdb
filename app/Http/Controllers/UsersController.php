<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	return view('owners/list');
    }

    public function show($id){
    	$owner = User::getByID($id);
        $clubs = Team::getByOwnerID($id);

    	return view('owners/show', compact('owner', 'clubs'));
    }

}