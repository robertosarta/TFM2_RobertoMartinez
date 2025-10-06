<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'categoria_id';

    protected $fillable = [
        'nombre',
    ];

    public function subcategorias() {
        return $this->hasMany(Subcategoria::class, 'categoria_id');
    }
}
