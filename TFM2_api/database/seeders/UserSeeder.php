<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Roberto',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'telefono' => '608854163',
            'direccion' => 'Calle Ejemplo 123',
            'rol' => 'admin',
        ]);
    }
}
