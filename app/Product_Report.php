<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Report extends Model
{
    protected $table = "product_reports";

    protected $fillable = [
        'product_id', 'size', 'flavor', 'store_id', 'client_id', 'reports_images', 'is_replaced'
    ];
}
