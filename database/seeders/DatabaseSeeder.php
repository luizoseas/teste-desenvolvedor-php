<?php

namespace Database\Seeders;

use App\Models\pedido;
use App\Models\cliente;
use App\Models\produto;
use App\Models\usuario;
use Illuminate\Database\Seeder;
use App\Models\fk_pedidos_produtos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        usuario::factory()->count(1)->create();
        produto::factory()->count(100)->create();
        cliente::factory()->count(100)->create();
        pedido::factory()->count(100)->create();
        fk_pedidos_produtos::factory()->count(100)->create();
    }
}
