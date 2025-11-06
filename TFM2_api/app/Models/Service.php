<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Service",
 *     title="Service",
 *     description="Service model",
 *     type="object",
 *     required={"id", "name", "email", "phone", "description", "price"},
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="name", type="string", example="Computer Repair"),
 *     @OA\Property(property="description", type="string", example="Repair and maintenance of laptops and PCs"),
 *     @OA\Property(property="price", type="number", format="float", example=49.99),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="subcategory_id", type="integer", example=5),
 *     @OA\Property(property="user", ref="#/components/schemas/User"),
 *     @OA\Property(property="subcategory", ref="#/components/schemas/Subcategory")
 * )
 */
class Service extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'description',
        'price',
        'user_id',
        'subcategory_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
