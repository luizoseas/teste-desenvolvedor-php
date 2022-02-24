<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cliente extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $primaryKey = 'codCliente';
    protected $fillable = [
        'nomeCliente',
        'CPF',
        'email',
    ];

    protected $hidden = [
        'senha',
    ];
    public function pedidos()
    {
        return $this->hasMany('App\Models\pedido', 'codCliente');
    }
}
