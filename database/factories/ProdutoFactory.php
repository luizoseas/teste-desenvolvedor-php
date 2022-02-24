<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = \App\Models\Produto::class;
    public function definition()
    {

        return [
            'nomeProduto' => $this->faker->word(),
            'valorUnitario' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
            'codBarras' => $this->faker->numberBetween($min = 1111111111111, $max = 9999999999999),
        ];
    }
}
