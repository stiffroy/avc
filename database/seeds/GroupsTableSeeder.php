<?php

use App\Entity\Client;
use App\Entity\Group;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Group::class, 10)->create()->each(function ($group) {
            $group->clients()->saveMany(factory(Client::class, rand(3, 5))->make());
        });
    }
}
