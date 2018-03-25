<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Stiff Roy',
            'email' => 'stiff.roy@gmail.com',
            'password' => bcrypt('avc123dash'),
            'created_at' => Carbon::now()->timezone('Europe/Vienna'),
        ]);
    }
}
