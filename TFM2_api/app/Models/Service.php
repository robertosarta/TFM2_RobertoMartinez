<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'user_id',
        'subcategory_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
