<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pedido extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $primaryKey = 'codPedido';
    public function cliente()
    {
        return $this->belongsTo('App\Models\cliente', 'codCliente');
    }
    public function produtos()
    {
        return $this->belongsToMany('App\Models\produto', 'fk_pedidos_produtos', 'codPedido', 'codProduto');
    }
    public function produtosFk()
    {
        return $this->hasMany('App\Models\fk_pedidos_produtos', 'codPedido','codPedido');
    }
    public function subTotal(){
        $total = 0;
        foreach($this->produtosFk as $produto){
            $total += ($produto->produto->valorUnitario ?? 0) * $produto->quantidade;
        }
        return $total;
    }
    public function Total(){
        $total = 0;
        foreach($this->produtosFk as $produto){
            $total += ($produto->produto->valorUnitario ?? 0) * $produto->quantidade;
        }
        $total = $total - $this->valorDesconto;
        if($total < 0){
            $total = 0;
        }
        return $total;
    }
}
