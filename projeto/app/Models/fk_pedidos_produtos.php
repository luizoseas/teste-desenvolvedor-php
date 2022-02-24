<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class fk_pedidos_produtos extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function produto(){
        return $this->belongsTo('App\Models\produto', 'codProduto');
    }
}
