<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class usuario extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'codUsuario';
    protected $hidden = [
        'senha',
    ];
    public function getAuthPassword(){
        return $this->senha;
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }
}
