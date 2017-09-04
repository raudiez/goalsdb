<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCJunction;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class JunctionsController extends Controller{

  public function junction_save(Request $request, $junction_id, $leg){
    $notes = $request->input('notes');
    $junction = LOFCJunction::getByID($junction_id);
    $ended = $junction->ended;
    $played_1 = $junction->played_1;
    $played_2 = $junction->played_2;
    $db_notes = $junction->notes;

    if ($junction->second_leg && $leg == 1){
      if ($notes != '') {
        if(preg_match('/Ida: (.+)\n/', $db_notes, $matches)){
          $notes = preg_replace('/Ida: (.+)\n/', "Ida: ".$notes."\n", $db_notes, 1);
        }else{
          $notes = $db_notes."Ida: ".$notes."\n";
        }
      }
      $played_1 = 1;
    }elseif ($junction->second_leg && $leg == 2){
      if ($notes != '') {
        if(preg_match('/Vuelta: (.+)\n/', $db_notes, $matches)){
          $notes = preg_replace('/Vuelta: (.+)\n/', "Vuelta: ".$notes."\n", $db_notes, 1);
        }else{
          $notes = $db_notes."Vuelta: ".$notes."\n";
        }
      }
      $played_2 = 1;
      $ended = 1;
    }else{ //Partido único, terminado.
      $played_1 = 1;
      $ended = 1;
    }
    LOFCJunction::updateJunctionMatch($junction_id, $played_1, $played_2, $ended, $notes);
    return redirect('lofc/show_competition/'.$junction->id_competition);
  }
        
}