<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCPalmares;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class PalmaresController extends Controller{

  public function show(){
    $palmaresText = LOFCPalmares::getText()->palmares;
    return view('lofc/palmares/show', compact('palmaresText'));
  }

  public function form(){
    $palmaresText = LOFCPalmares::getText()->palmares;
    return view('lofc/palmares/form', compact('palmaresText'));
  }

  public function save(Request $request){
    $palmaresText = $request->input('palmaresText');
    LOFCPalmares::updateText($palmaresText);
    return redirect('lofc/palmares');
  }
        
}