<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDamages extends Model
{
    protected $table = "product_damages";

    protected $fillable = [
        'order_id', 'product_id', 'size', 'flavor', 'client_id', 'is_replaced'
    ];
}
