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
    }
}
