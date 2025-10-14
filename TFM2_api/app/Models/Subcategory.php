<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Subcategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 
        'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');     
    }

    public function services() {
        return $this->hasMany(Service::class, 'subcategory_id');
    }
}
