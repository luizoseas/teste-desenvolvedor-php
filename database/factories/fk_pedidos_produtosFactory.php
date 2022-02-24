<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\fk_pedidos_produtos>
 */
class fk_pedidos_produtosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = \App\Models\fk_pedidos_produtos::class;
    public function definition()
    {
        return [
            'codPedido' => $this->faker->numberBetween($min = 1, $max = 100),
            'codProduto' => $this->faker->numberBetween($min = 1, $max = 100),
            'quantidade' => $this->faker->numberBetween($min = 1, $max = 5),
        ];
    }
}
