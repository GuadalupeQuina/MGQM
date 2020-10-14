<?php

use App\categoria;
use App\mesa;
use App\producto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // factory(categoria::class,20)->create();
        // factory(mesa::class,30)->create();
        // factory(producto::class,50)->create();
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
