<?php

use App\Team;
use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::create(['name' => 'Atlético de Madrid', 'logo' => 'atletico']);
        Team::create(['name' => 'Chelsea FC', 'logo' => 'chelsea']);
        Team::create(['name' => 'Manchester United FC', 'logo' => 'manud']);
    }
}
