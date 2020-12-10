<?php

namespace App;

use App\Product;
use App\Product_Report;
use Illuminate\Database\Eloquent\Model;

class ReplacementProduct extends Model
{
	protected $guarded = [];
	protected $appends = ['name'];

    public function productReport()
    {
    	return $this->belongsTo(Product_Report::class);
    }

    public function productDetails()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    }

    public function getNameAttribute()
    {
    	return $this->productDetails->name;
    }
}
