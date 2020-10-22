<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFileReport extends Model
{
    protected $table = "product_file_reports";

    protected $fillable = [
        'product_report_id', 'file_report_image'
    ];
}
