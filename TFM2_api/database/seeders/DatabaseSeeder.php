<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Servicio;
use App\Models\Subcategoria;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        User::factory(19)->create();
        Categoria::factory(20)->create();
        Subcategoria::factory(20)->create();
        Servicio::factory(20)->create();
    }
}
