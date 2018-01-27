<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCEstadisticas;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class EstadisticasController extends Controller{

  public function show(){
    $statsText = LOFCEstadisticas::getText()->stats;
    return view('lofc/stats/show', compact('statsText'));
  }

  public function form(){
    $statsText = LOFCEstadisticas::getText()->stats;
    return view('lofc/stats/form', compact('statsText'));
  }

  public function save(Request $request){
    $statsText = $request->input('statsText');
    LOFCEstadisticas::updateText($statsText);
    return redirect('lofc/stats');
  }
        
}