<?php

use App\Record;
use Illuminate\Database\Seeder;

class RecordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$records = [

	    //ATLETICO DE MADRID
	    ['player_id' => 21, 'goals' => 100],
	    ['player_id' => 10, 'goals' => 200],

	    //CHELSEA
	    ['player_id' => 78, 'goals' => 100],
	    ['player_id' => 53, 'goals' => 200],

	    //MANCHESTER UNITED
	    ['player_id' => 123, 'goals' => 100],
	    ['player_id' => 120, 'goals' => 200],
	    ['player_id' => 126, 'goals' => 300],
	    ['player_id' => 125, 'goals' => 400],
	    ['player_id' => 100, 'goals' => 500],
	    ['player_id' => 126, 'goals' => 600],
	    ['player_id' => 129, 'goals' => 700],
	    ['player_id' => 106, 'goals' => 800],
	    ['player_id' => 129, 'goals' => 900],

	    //PES UNITED (PRUEBAS)
	    ['player_id' => 144, 'goals' => 100],
	    ['player_id' => 144, 'goals' => 200],
	    ['player_id' => 144, 'goals' => 300],
	    ['player_id' => 144, 'goals' => 400],

	    ];
	    foreach ($records as $record) {
	    	Record::create($record);
	    }
    }
}
