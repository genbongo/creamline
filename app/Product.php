<?php

namespace App;

use App\Stock;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'product_image'
    ];

    public function stock()
    {
    	return $this->hasOne(Stock::class);
    }
}
