<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = \App\Models\Cliente::class;
    public function definition()
    {
        return [
            'nomeCliente' => $this->faker->name(),
            'CPF' => $this->faker->numberBetween($min = 11111111111, $max = 99999999999),
            'email' => $this->faker->email,
        ];
    }
}
