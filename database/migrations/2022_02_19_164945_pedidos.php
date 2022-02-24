<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos',function($table){
            $table->id('codPedido');
            $table->timestamp('dtPedido',100);
            $table->string('status');
            $table->float('valorDesconto',11);
            $table->unsignedBigInteger('codCliente');
            $table->foreign('codCliente')->references('codCliente')->on('clientes');
            $table->softDeletes();
        });
        Schema::create('fk_pedidos_produtos',function($table){
            $table->id();
            $table->unsignedBigInteger('codPedido');
            $table->unsignedBigInteger('codProduto');
            $table->foreign('codProduto')->references('codProduto')->on('produtos');
            $table->foreign('codPedido')->references('codPedido')->on('pedidos');
            $table->integer('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('fk_pedidos_produtos');
    }
};
