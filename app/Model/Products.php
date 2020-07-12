<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $table = "products";

    protected $fillable=[
        'name',
        'precio',
        'stock'
    ];

    public $timestamps = false;
}
