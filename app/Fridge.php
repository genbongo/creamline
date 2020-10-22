<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fridge extends Model
{
    protected $fillable = [
        'user_id', 'model', 'description', 'location', 'status'
    ];
}
