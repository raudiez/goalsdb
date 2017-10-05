<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCSeason;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class SeasonsController extends Controller{

  public function form(){
    return view('lofc/seasons/form');
  }

  public function save(){
  	$season = new LOFCSeason;
  	$season->save();
    return redirect('lofc/competitions/'.$season->id);
  }
  
}