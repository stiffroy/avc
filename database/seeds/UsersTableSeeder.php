<?php

use App\Entity\User;
use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@dashboard.avc',
            'password' => 'avc123admin',
        ]);

        $role = Role::where('name', '=', 'Admin')->first();
        $user->attachRole($role);
    }
}
