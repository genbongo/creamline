<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id', 'delivery_date', 'store_id', 'product_id', 'size', 'flavor', 'quantity_ordered', 'ordered_total_price', 'quantity_received', 'received_total_price', 'is_approved', 'is_completed'
    ];
}
