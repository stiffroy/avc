<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Permission;
use Ultraware\Roles\Models\Role;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions
         *
         */
        $permissions = Permission::all();

        /**
         * Attach Permissions to Roles
         *
         */
        $roleAdmin = Role::where('name', '=', 'Admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }
    }
}
