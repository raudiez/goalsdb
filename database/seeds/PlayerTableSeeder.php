<?php

use App\Team;
Use App\Player;
use Illuminate\Database\Seeder;

class PlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run(){
  	$teams = Team::all();

    $players = [

    //ATLETICO DE MADRID
    ['team_id' => 1, 'name' => 'Benzema', 'goals_club' => 10, 'goals_career' => 0],
    ['team_id' => 1, 'name' => 'Konoplyanka', 'goals_club' => 15, 'goals_career' => 0],


    //CHELSEA
    ['team_id' => 2, 'name' => 'Dybala', 'goals_club' => 20, 'goals_career' => 2],
    ['team_id' => 2, 'name' => 'Cristiano Ronaldo', 'goals_club' => 27, 'goals_career' => 0],
    ['team_id' => 2, 'name' => 'Oscar', 'goals_club' => 18, 'goals_career' => 1],
    ['team_id' => 2, 'name' => 'RESTO', 'goals_club' => 7, 'goals_career' => 0],


    //MANCHESTER UNITED
    ['team_id' => 3, 'name' => 'Ibrahimovic', 'goals_club' => 63, 'goals_career' => 3],

    ];
    foreach ($players as $player) {
    	Player::create($player);
    }
  }
}
