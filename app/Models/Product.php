<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'price',
        'stock',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
