<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'update users']);


        $role = Role::create(['name'=>'administrador']);
        $role->givePermissionTo(Permission::all());


        $role = Role::create(['name'=>'repartidor']);
        $role->givePermissionTo('create users');
        $role->givePermissionTo('update users');
        $role->givePermissionTo('show users');

        $role = Role::create(['name'=> 'cliente']);
        $role->givePermissionTo('show users');


        // $role = Role::create(['name'=> 'invitado']);



    }
}
