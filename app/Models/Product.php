<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'is_hot',
        'is_featured',
        'views',
        'sales',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
