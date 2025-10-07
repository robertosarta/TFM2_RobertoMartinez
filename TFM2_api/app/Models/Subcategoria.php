<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Subcategoria extends Model
{
    use HasFactory;

    protected $primaryKey = 'subcategoria_id';

    protected $fillable = [
        'nombre', 
        'categoria_id'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'categoria_id');     
    }

    public function servicios() {
        return $this->hasMany(Servicio::class, 'subcategoria_id');
    }
}
