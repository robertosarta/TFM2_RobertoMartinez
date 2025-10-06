<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, notifiable;

    protected $primaryKey = 'usuario_id';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'rol',
    ];

    public function servicios() {
        return $this->hasMany(servicios::class, 'usuario_id');
    }
}
