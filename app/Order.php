<?php

namespace App;

use App\Store;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id', 'delivery_date', 'store_id', 'product_id', 'size', 'flavor', 'quantity_ordered', 'ordered_total_price', 'quantity_received', 'received_total_price', 'is_approved', 'is_completed'
    ];

    public function store()
    {
    	return $this->belongsTo(Store::class);
    }

    public function client()
    {
    	return $this->belongsTo(User::class, 'client_id');
    }
}
