<?php

namespace App;

use App\Size;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Flavor extends Model
{
	protected $guarded = [];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

    public function sizes()
    {
    	return $this->hasMany(Size::class);
    }
}
