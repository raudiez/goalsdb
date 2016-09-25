<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create(['name' => 'reddevilrau', 'email' => 'rauldiez20@gmail.com', 'password' => '$2y$10$C7Aa.KJkgbNs7jRgRfFE2.2Udroim3SVsp2aO.pbamY8efL2fAhkO']);
      User::create(['name' => 'enriquepsy10', 'email' => 'enriquerafael8@gmail.com', 'password' => '$2y$10$9ITuMEjuJfz1o4.QaNJOvOQr6gqlTMI0ciZBPaOn4K3eh2kpKVxdy']);
      User::create(['name' => 'ipuyana22', 'email' => 'ipuyana22@gmail.com', 'password' => '$2y$10$nB8WcXgiHzSuBCmU/Oz5v./PsQShMdF/pEomjzON4uyvKwvga0lau']);
      User::create(['name' => 'barinho', 'email' => 'reddevilrau@gmail.com', 'password' => '$2y$10$Hjx9TG/FY.OBW9exgOGOFu4NtoTrjhpKuunSy5xfkQMZGISdjGGQq']);

    }
}
