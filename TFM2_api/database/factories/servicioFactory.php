<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Subcategoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\servicio>
 */
class servicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'descripcion' => $this->faker->sentence(10),
            'usuario_id' => User::inRandomOrder()->first()->id,
            'subcategoria_id' => Subcategoria::inRandomOrder()->first()->id,
        ];
    }
}
