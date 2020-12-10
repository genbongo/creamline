<?php

namespace App;

use App\ProductFileReport;
use App\ReplacementProduct;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Product_Report extends Model
{
    protected $table = "product_reports";

    protected $fillable = [
        'product_id', 'size', 'flavor', 'store_id', 'client_id', 'reports_images', 'is_replaced'
    ];

    public function products()
    {
    	return $this->hasMany(ReplacementProduct::class, 'product_report_id');
    }

    public function client()
    {
    	return $this->belongsTo(User::class, 'client_id');
    }

    public function images()
    {
    	return $this->hasMany(ProductFileReport::class, 'product_report_id');
    }
}
