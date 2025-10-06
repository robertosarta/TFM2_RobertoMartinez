<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'servicios_id';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'descripcion',
        'usuario_id',
        'subcategoria_id'
    ];

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function subcategoria() {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }
}
