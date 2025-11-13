<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'phone' => '608854163',
            'address' => 'Calle Ejemplo 123',
            'role' => 'admin',
            //no le pongo el remember token porque al ser admin me parece mejor asi
        ]);

        User::create([
            'name' => 'Carlos',
            'email' => 'cliente@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('cliente123'),
            'phone' => '600112233',
            'address' => 'Avenida Central 45',
            'role' => 'cliente',
        ]);
    }
}
