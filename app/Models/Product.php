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
        'slug',
        'category_id',
        'stock',
        'price',
        'image',
    ];

    //crear la funcion que indique que tenemos relacion concategorias
    //un producto tendra solo uan categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
