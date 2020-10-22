<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = [
        'product_id', 'size', 'flavor', 'price'
    ];
}
