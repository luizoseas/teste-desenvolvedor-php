<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = \App\Models\Pedido::class;
    public function definition()
    {
        return [
            'dtPedido' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
            'status' => $this->faker->randomElement($array = array ('Em Aberto', 'Pago', 'Cancelado')),
            'valorDesconto' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
            'codCliente' => $this->faker->numberBetween($min = 1, $max = 100),
        ];
    }
}
