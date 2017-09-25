<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCReglamento;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class ReglamentoController extends Controller{

  public function show(){
    $reglamentoText = LOFCReglamento::getText()->reglamento;
    return view('lofc/reglamento/show', compact('reglamentoText'));
  }

  public function form(){
    $reglamentoText = LOFCReglamento::getText()->reglamento;
    return view('lofc/reglamento/form', compact('reglamentoText'));
  }

  public function save(Request $request){
    $reglamentoText = $request->input('reglamentoText');
    LOFCReglamento::updateText($reglamentoText);
    return redirect('lofc/reglamento/show');
  }
        
}