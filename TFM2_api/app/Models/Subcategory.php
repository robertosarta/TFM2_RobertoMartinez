<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *     schema="Subcategory",
 *     title="Subcategory",
 *     description="Subcategory model",
 *     type="object",
 *     required={"id", "name", "category_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Laptops"),
 *     @OA\Property(property="category_id", type="integer", example=1),
 *     @OA\Property(property="category", ref="#/components/schemas/CategoryBasic")
 * )
 */
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

 
