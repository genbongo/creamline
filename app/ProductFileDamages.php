<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFileDamages extends Model
{
    protected $table = "product_file_damages";

    protected $fillable = [
        'product_damage_id', 'file_damage_image'
    ];
}
