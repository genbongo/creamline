<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'product_image', 'product_name', 'product_description', 'size', 'flavor', 'quantity', 'subtotal',
    ];
}
